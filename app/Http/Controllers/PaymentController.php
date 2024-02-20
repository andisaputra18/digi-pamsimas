<?php

namespace App\Http\Controllers;

use App\Models\AdminFeePartner;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\RecordMeter;
use App\Models\Setting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $areaCode = auth()->user()->kode_area;
        $payments = Payment::with(['catat_meter', 'catat_meter.pelanggan'])->where("kode_area", $areaCode)->get();
        // echo json_encode($payments);die;

        return view('payment.view', compact('payments'));
    }

    public function create()
    {
        $areaCode = auth()->user()->kode_area;

        $customers = Customer::where('kode_area', $areaCode)->get();
        $setting = Setting::where(["status" => 1, "kode_area" => $areaCode])->first();
        $fee_admin = AdminFeePartner::with(['biaya'])->where("kode_area", $areaCode)->first();

        return view('payment.form', compact('customers', 'setting', 'fee_admin'));
    }

    public function store(Request $request)
    {
        $areaCode = auth()->user()->kode_area;
        $payment = new Payment;

        $record = RecordMeter::with(['pelanggan'])->where("id", $request->input('catat_meter_id'))->first();

        $payment->no_transaksi = date('Y') . date('m') . $record->pelanggan->no_pelanggan;
        $payment->catat_meter_id = $request->input('catat_meter_id');
        $payment->tgl_pembayaran = $request->input('tgl_pembayaran');
        $payment->total_tagihan = $request->input('total_tagihan');
        $payment->uang_dibayarkan = str_replace(".", "", $request->input('uang_dibayarkan'));
        $payment->kode_area = $areaCode;
        $payment->save();

        session(["message_success" => "Transaksi pembayaran baru berhasil dibuat"]);
        return redirect('pembayaran');
    }

    public function check_has_payment($no_pelanggan)
    {
        $customer = Customer::where("no_pelanggan", $no_pelanggan)->first();
        $hasPayment = Payment::where(["pelanggan_id" => $customer->id, "tahun" => date('Y'), "bulan" => date('m')])->count();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $hasPayment]);
    }

    public function get_prev_month($no_pelanggan)
    {
        $customer = Customer::where("no_pelanggan", $no_pelanggan)->first();
        $month = date('m');
        $prev_month = $month - 1;

        $prev_month_payment = Payment::where(["pelanggan_id" => $customer->id, "tahun" => date('Y'), "bulan" => $prev_month])->first();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $prev_month_payment]);
    }

    public function show($id)
    {
        // $areaCode = auth()->user()->kode_area;
        // $year = date('Y');
        // $prev_month = date('m') - 1;

        // $record = RecordMeter::with(['pelanggan', 'pelanggan.kategori'])->where("id", $id)->first();
        // $last_record = RecordMeter::with(['pembayaran'])->where(["tahun" => $year, "bulan" => $prev_month])->first();
        // $setting = Setting::where(["status" => 1, "kode_area" => $areaCode])->first();
        // $fee_admin = AdminFeePartner::with(['biaya'])->where("kode_area", $areaCode)->first();
        // // echo json_encode($setting);die;

        // return view('payment.payment_detail', compact('setting', 'fee_admin', 'record', 'last_record'));
        return redirect()->route('pembayaran.index');
    }

    public function modal(){
        return view('payment.modal');
    }
}
