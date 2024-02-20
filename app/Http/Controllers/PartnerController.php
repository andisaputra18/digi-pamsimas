<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Region;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::all();

        return view('partner.view', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Region::whereRaw("LENGTH(id) = 2")->orderBy('name', "ASC")->get();

        return view('partner.form', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode_area = $request->input('kode_area');
        $region = Region::where("id", $kode_area)->first();
        $district = Region::where("id", $request->input('kecamatan'))->first();
        $regency = Region::where("id", $request->input('kabupaten'))->first();
        $province = Region::where("id", $request->input('provinsi'))->first();

        $partner = new Partner;
        $partner->nama_pamsimas = $request->input('nama_pamsimas');
        $partner->kode_area = $kode_area;
        $partner->wilayah = $region->name;
        $partner->kecamatan = $district->name;
        $partner->kabupaten = $regency->name;
        $partner->provinsi = $province->name;
        $partner->save();

        session(["message_success" => "Mitra baru berhasil ditambahkan"]);
        return redirect('mitra');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Partner::find($id);
        $provinces = Region::whereRaw("LENGTH(id) = 2")->orderBy('name', "ASC")->get();
        $regencies = Region::where("pid", substr($partner->kode_area, 0, 2))->orderBy('name', 'asc')->get();
        $districts = Region::where("pid", substr($partner->kode_area, 0, 5))->orderBy('name', 'asc')->get();
        $villages = Region::where("pid", substr($partner->kode_area, 0, 8))->orderBy('name', 'asc')->get();

        return view('partner.form', compact('partner', 'provinces', 'regencies', 'districts', 'villages'));
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
        $kode_area = $request->input('kode_area');
        $region = Region::where("id", $kode_area)->first();
        $district = Region::where("id", $request->input('kecamatan'))->first();
        $regency = Region::where("id", $request->input('kabupaten'))->first();
        $province = Region::where("id", $request->input('provinsi'))->first();

        $partner = Partner::find($id);
        $partner->nama_pamsimas = $request->input('nama_pamsimas');
        $partner->kode_area = $kode_area;
        $partner->wilayah = $region->name;
        $partner->kecamatan = $district->name;
        $partner->kabupaten = $regency->name;
        $partner->provinsi = $province->name;
        $partner->save();

        session(["message_success" => "Data mitra berhasil diperbaharui"]);
        return redirect('mitra');
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

    public function delete($id)
    {
        $partner = Partner::find($id);
        $partner->delete();

        session(["message_success" => "Data mitra berhasil dihapus"]);
        return redirect('mitra');
    }
}
