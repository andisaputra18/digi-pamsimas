<?php

namespace App\Http\Controllers;

use App\Models\AdminFee;
use App\Models\AdminFeePartner;
use App\Models\Partner;
use Illuminate\Http\Request;

class AdminFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees = AdminFee::with(['mitra'])->get();

        return view('admin_fee.view', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_fee._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fee = new AdminFee;
        $fee->biaya = $request->input('biaya');
        $fee->save();

        session(["message_success" => "Biaya admin berhasil ditambahkan"]);
        return redirect('biaya_admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fee = AdminFee::find($id);
        $feePartners = AdminFeePartner::with(['mitra'])->where("biaya_admin_id", $id)->get();

        return view('admin_fee.detail', compact('fee', 'feePartners'));
    }

    public function add_mitra($id)
    {
        $fee = AdminFee::find($id);
        $partners = Partner::all();

        return view('admin_fee._mitra', compact('fee', 'partners'));
    }

    public function insert_mitra(Request $request)
    {
        $biaya_admin_id = $request->input('biaya_admin_id');

        $feePartner = new AdminFeePartner;
        $feePartner->biaya_admin_id = $biaya_admin_id;
        $feePartner->kode_area = $request->input('kode_area');
        $feePartner->save();

        session(["message_success" => "Mitra berhasil ditambahan ke biaya admin"]);
        return redirect("biaya_admin/$biaya_admin_id");
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

    public function delete_mitra($kode_area)
    {
        $fee_partner = AdminFeePartner::where("kode_area", $kode_area)->first();
        $biaya_admin_id = $fee_partner->biaya_admin_id;
        $fee_partner->delete();

        session(["message_success" => "Mitra berhasil dihapus dari biaya admin"]);
        return redirect("biaya_admin/$biaya_admin_id");
    }
}
