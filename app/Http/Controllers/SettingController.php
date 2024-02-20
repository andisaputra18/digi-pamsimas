<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areaCode = auth()->user()->kode_area;
        $settings = Setting::with(['category'])->where("kode_area", $areaCode)->get();

        return view('setting.view', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('setting.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $areaCode = auth()->user()->kode_area;

        $pengaturan_biaya = $request->input('pengaturan_biaya');
        $biaya = $this->setCost($pengaturan_biaya, $request);

        $setting = new Setting;
        $setting->kategori_bangunan_id = $request->input('kategori_bangunan_id');
        $setting->biaya_abodemen = (int) str_replace(".", "", $request->input('biaya_abodemen'));
        $setting->pengaturan_biaya = $pengaturan_biaya;
        $setting->biaya = json_encode($biaya);
        $setting->kode_area = $areaCode;
        $setting->save();

        session(["message_success" => "Setting biaya baru berhasil ditambahkan"]);
        return redirect('rumus');
    }

    protected function setCost($param, $request)
    {
        $slug = $param == 1 ? "sekali" : "rentan";

        $angka_meter_akhir = $request->input("angka_meter_akhir_$slug");
        $tarif = $request->input("tarif_$slug");
        $biaya = [];
        foreach ($request->input("angka_meter_awal_$slug") as $key => $item) {
            $angka_awal = $item;
            $angka_akhir = $angka_meter_akhir[$key];
            $tarif_ = str_replace(".", "", $tarif[$key]);

            $data = [
                "angka_awal" => $angka_awal,
                "angka_akhir" => $angka_akhir,
                "tarif" => $tarif_,
            ];

            $biaya[] = $data;
        }

        return $biaya;
    }

    protected function setCost2($param, $request)
    {
        $slug = $param == 1 ? "sekali" : "rentan";

        $angka_meter_akhir = $request->input("angka_meter_akhir_$slug");
        $tarif = $request->input("tarif_$slug");
        $biaya = [];
        foreach ($request->input("angka_meter_awal_$slug") as $key => $item) {
            $biaya[$key][] = $item;
            $biaya[$key][] = $angka_meter_akhir[$key];
            $biaya[$key][] = str_replace(".", "", $tarif[$key]);
        }

        return $biaya;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function biaya($no_pelanggan)
    {
        $areaCode = auth()->user()->kode_area;
        $customer = Customer::where("no_pelanggan", $no_pelanggan)->first();
        $setting = Setting::where(["kategori_bangunan_id" => $customer->kategori_bangunan_id, "status" => 1, "kode_area" => $areaCode])->first();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $setting]);
    }

    public function check($id_pelanggan)
    {
        $setting = Setting::find($id_pelanggan);

        return response()->json(["message" => "Data berhasil dimuat", "data" => $setting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::with(['category'])->where("id", $id)->first();
        $categories = Category::all();

        return view('setting.edit', compact('setting', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $areaCode = auth()->user()->kode_area;

        $pengaturan_biaya = $request->input('pengaturan_biaya');
        $biaya = $this->setCost($pengaturan_biaya, $request);

        $setting = Setting::find($id);
        $setting->kategori_bangunan_id = $request->input('kategori_bangunan_id');
        $setting->biaya_abodemen = (int) str_replace(".", "", $request->input('biaya_abodemen'));
        $setting->pengaturan_biaya = $pengaturan_biaya;
        $setting->biaya = json_encode($biaya);
        $setting->kode_area = $areaCode;
        $setting->save();

        session(["message_success" => "Setting biaya berhasil diperbaharui"]);
        return redirect('rumus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status($id)
    {
        $areaCode = auth()->user()->kode_area;
        $setting = Setting::find($id);

        $status = "";
        if ($setting->status == 1) {
            $setting->status = 0;
            $setting->save();
            $status = "Tidak Aktif";
        } else {
            $isActive = Setting::where(["status" => 1, "kategori_bangunan_id" => $setting->kategori_bangunan_id, "kode_area" => $areaCode])->count();
            if ($isActive > 0) {
                session(["message_error" => "Status setting biaya tidak boleh lebih dari 1 yang aktif!"]);
                return redirect('rumus');
            } else {
                $setting->status = 1;
                $setting->save();
                $status = "Aktif";
            }
        }

        session(["message_success" => "Status setting biaya berhasil dirubah menjadi $status"]);
        return redirect('rumus');
    }

    public function delete($id)
    {
        $setting = Setting::find($id);
        $setting->delete();

        session(["message_success" => "Setting biaya berhasil dihapus"]);
        return redirect('rumus');
    }
}
