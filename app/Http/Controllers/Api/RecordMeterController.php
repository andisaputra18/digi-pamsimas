<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\RecordMeter;
use App\Models\Setting;
use Illuminate\Http\Request;

class RecordMeterController extends Controller
{
    public function prev_month($customer_number)
    {
        try {
            $month = date('m');
            $prev_month = $month - 1;

            $year = $prev_month == 0 ? date('Y') - 1 : date('Y');
            $prev_month = $prev_month == 0 ? 12 : $prev_month;

            $data = RecordMeter::with(['pelanggan'])->where(["no_pelanggan" => $customer_number, "tahun" => $year, "bulan" => $prev_month])->first();

            return response()->json(["message" => "Data berhasil dimuat", "data" => $data]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function this_month(Request $request, $customer_number)
    {
        try {
            $record = new RecordMeter();
            $record->no_pelanggan = $customer_number;
            $record->tahun = date('Y');
            $record->bulan = date('m');
            $record->angka_meter = $request->angka_meter;
            $record->volume = $request->volume;
            $record->kode_area = $request->kode_area;
            $record->save();

            return response()->json(["message" => "Data catat meter berhasil ditambahkan"]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function detail($id)
    {
        try {
            $prev_month = date('m') - 1;

            $year = $prev_month == 0 ? date('Y') - 1 : date('Y');
            $prev_month = $prev_month == 0 ? 12 : $prev_month;

            $last_record = RecordMeter::with(['pembayaran'])->where(["tahun" => $year, "bulan" => $prev_month])->first();
            $record = RecordMeter::with(['pelanggan', 'pelanggan.kategori', 'pelanggan.setting', 'biaya_admin.biaya'])->where("id", $id)->first();
            $record->catat_meter_terakhir = $last_record;

            $data = $record;

            return response()->json(["message" => "Data berhasil dimuat", "data" => $data]);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }

    public function loket($area)
    {
        try {
            //code...
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()]);
        }
    }
}
