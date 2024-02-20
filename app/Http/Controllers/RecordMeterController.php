<?php

namespace App\Http\Controllers;

use App\Models\AdminFeePartner;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\RecordMeter;
use App\Models\Setting;
use Illuminate\Http\Request;

class RecordMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areaCode = auth()->user()->kode_area;

        $customers = Customer::where('kode_area', $areaCode)->get();
        $setting = Setting::where(["status" => 1, "kode_area" => $areaCode])->first();

        return view('record_meter.form', compact('customers', 'setting'));
    }

    public function check_record_meter($no_pelanggan)
    {
        $record = RecordMeter::where(["no_pelanggan" => $no_pelanggan, "tahun" => date('Y'), "bulan" => date('m')])->first();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $record]);
    }

    public function get_prev_month($no_pelanggan)
    {
        $month = date('m');
        $prev_month = $month - 1;

        $year = $prev_month == 0 ? date('Y') - 1 : date('Y');
        $prev_month = $prev_month == 0 ? 12 : $prev_month;

        $prev_month_payment = RecordMeter::where(["no_pelanggan" => $no_pelanggan, "tahun" => $year, "bulan" => $prev_month])->first();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $prev_month_payment]);
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

        $record = new RecordMeter;
        $record->no_pelanggan = $request->input('no_pelanggan');
        $record->tahun = date('Y');
        $record->bulan = date('m');
        $record->angka_meter = $request->input('angka_meter');
        $record->volume = $request->input('volume');
        $record->kode_area = $areaCode;
        $record->save();
        $record->id;

        session(["message_success" => "Catat meter baru berhasil ditambahkan"]);
        return redirect()->route('catat_meter.show', $record->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areaCode = auth()->user()->kode_area;
        $prev_month = date('m') - 1;

        $year = $prev_month == 0 ? date('Y') - 1 : date('Y');
        $prev_month = $prev_month == 0 ? 12 : $prev_month;

        $hasPayment = Payment::where("catat_meter_id", $id)->first();
        if (!is_null($hasPayment)) {
            session(["message_error" => "Pembayaran sudah dilakukan"]);
            return redirect()->route('pembayaran.index');
        }

        $record = RecordMeter::with(['pelanggan', 'pelanggan.kategori'])->where("id", $id)->first();
        $last_record = RecordMeter::with(['pembayaran'])->where(["tahun" => $year, "bulan" => $prev_month])->first();
        $setting = Setting::where(["status" => 1, "kode_area" => $areaCode])->first();
        $fee_admin = AdminFeePartner::with(['biaya'])->where("kode_area", $areaCode)->first();
        // echo json_encode($setting);die;

        return view('record_meter.detail', compact('setting', 'fee_admin', 'record', 'last_record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
