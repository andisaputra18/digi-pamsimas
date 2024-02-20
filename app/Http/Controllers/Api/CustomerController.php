<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function search($search = '!*@&#)@(!*)%$(&@!(#^')
    {
        try {
            $data = Customer::with(['kategori'])
                ->where(function ($query) use ($search) {
                    $query->where('no_pelanggan', 'like', '%' . $search . '%');
                    $query->orWhere('nama_lengkap', 'like', '%' . $search . '%');
                })
                ->get();

            return response()->json(["message" => "Data berhasil dimuat", "data" => $data]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function list($area)
    {
        try {
            $data = Customer::with(['kategori'])->where("kode_area", $area)->get();

            return response()->json(["message" => "Data berhasil dimuat", "data" => $data]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
}
