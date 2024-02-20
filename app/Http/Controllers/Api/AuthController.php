<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfficerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        try {
            $account = OfficerAccount::where('username', $request->username)->first();
            if (!$account || !Hash::check($request->password, $account->password)) {
                return response()->json(["message" => "Login Gagal"], 401);
            } else {
                $isLogin = $this->isLogin($request->only('username'));
                if (!is_null($isLogin)) {
                    return response()->json(["message" => "Akun sudah login di perangkat lain"], 401);
                } else {
                    OfficerAccount::where('username', $request->username)->update(['device_id' => Hash::make($request->username)]);

                    $data = OfficerAccount::join('oip_petugas as p', 'oip_akun_petugas.petugas_id', '=', 'p.id')
                        ->join('oip_mitra as m', 'p.mitra_id', '=', 'm.id')
                        ->selectRaw('p.nik, p.nama_lengkap, m.kode_area, m.nama_pamsimas, m.wilayah')
                        ->where('oip_akun_petugas.username', $account->username)
                        ->first();

                    $data->token = $account->createToken('token-login')->plainTextToken;
                    $data->url = url('api');
                }
            }
            return response()->json(["message" => "Login Berhasil", "data" => $data], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function isLogin($account)
    {
        $isLogin = OfficerAccount::where('username', $account)->first();

        if (!is_null($isLogin->device_id)) return $isLogin;
    }

    public function logout(Request $request, $id)
    {
        try {
            OfficerAccount::where('petugas_id', $id)->update(["device_id" => null]);
            $account = $request->user();
            $account->currentAccessToken()->delete();

            return response()->json(["message" => "Berhasil Logout"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
}
