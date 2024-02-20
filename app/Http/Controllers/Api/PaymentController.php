<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\RecordMeter;
use App\Models\Setting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function history($area)
    {
        try {
            $record = RecordMeter::with(['pembayaran', 'pelanggan'])->where("kode_area", $area)->get();

            return response()->json(["message" => "Data berhasil dimuat", "data" => $record]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function record_meter(Request $request, $id)
    {
        try {
            $customer = Customer::find($id);
            $setting_biaya = Setting::where(["kategori_bangunan_id" => $customer->kategori_bangunan_id, "status" => 1, "kode_area" => $customer->kode_area])->first();

            $payment = new Payment;
            $payment->no_transaksi = date('Y') . date('m') . $customer->no_pelanggan;
            $payment->pelanggan_id = $request->pelanggan_id;
            $payment->setting_biaya_id = $setting_biaya->id;
            $payment->tahun = date('Y');
            $payment->bulan = date('m');
            $payment->posisi_meter = $request->posisi_meter;
            $payment->volume = $request->volume;
            $payment->total_tagihan = $request->total_tagihan ?? 0;
            $payment->uang_dibayarkan = $request->uang_dibayarkan == "" ? 0 : str_replace(".", "", $request->uang_dibayarkan);
            $payment->kode_area = $customer->kode_area;
            $payment->save();

            return response()->json(["message" => "Data berhasil ditambahkan"]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
}
