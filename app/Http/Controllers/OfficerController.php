<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Models\OfficerAccount;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::withCount(['petugas'])->get();

        return view('officer.view', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('officer._form');
    }

    public function add($id)
    {
        $partner = Partner::find($id);

        return view('officer._form', compact('partner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $officer = new Officer;

        $phone_number = $request->input('no_telpon');

        $officer->mitra_id = $request->input('mitra_id');
        $officer->nik = $request->input('nik');
        $officer->nama_lengkap = $request->input('nama_lengkap');
        $officer->jenis_kelamin = $request->input('jenis_kelamin');
        $officer->no_telpon = $phone_number;
        $officer->alamat = $request->input('alamat');
        $officer->save();
        $officer_id = $officer->id;

        $account = new OfficerAccount;
        $account->petugas_id = $officer_id;
        $account->username = $phone_number;
        $account->password = Hash::make("ptg.test");
        $account->save();

        session(["message_success" => "Data petugas berhasil ditambahkan"]);
        return redirect()->route('petugas.show', $request->mitra_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $partner = Partner::find($id);
        $officers = Officer::where("mitra_id", $id)->get();

        return view('officer.detail', compact('partner', 'officers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $officer = Officer::find($id);
        $partner = Partner::find($officer->mitra_id);

        return view('officer._form', compact('officer', 'partner'));
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
        $officer = Officer::find($id);

        $mitra_id = $request->input('mitra_id');

        $officer->mitra_id = $request->input('mitra_id');
        $officer->nik = $request->input('nik');
        $officer->nama_lengkap = $request->input('nama_lengkap');
        $officer->jenis_kelamin = $request->input('jenis_kelamin');
        $officer->no_telpon = $request->input('no_telpon');
        $officer->alamat = $request->input('alamat');
        $officer->save();

        session(["message_success" => "Data petugas berhasil diperbaharui"]);
        return redirect()->route('petugas.show', $mitra_id);
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
        $officer = Officer::find($id);
        $mitra_id = $officer->mitra_id;
        $officer->delete();

        $account = OfficerAccount::where("petugas_id", $id)->first();
        $account->delete();

        session(["message_success" => "Data petugas berhasil dihapus"]);
        return redirect()->route('petugas.show', $mitra_id);
    }
}
