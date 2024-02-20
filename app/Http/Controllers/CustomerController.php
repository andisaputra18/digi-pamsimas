<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areaCode = auth()->user()->kode_area;

        $customers = Customer::where('kode_area', $areaCode)->get();

        return view('customer.view', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('customer.form', compact('categories'));
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

        $customer = new Customer;
        $customer->no_pelanggan = $request->input('no_pelanggan');
        $customer->kategori_bangunan_id = $request->input('kategori_bangunan_id');
        $customer->nik = $request->input('nik');
        $customer->nama_lengkap = $request->input('nama_lengkap');
        $customer->alamat = $request->input('alamat');
        $customer->kode_area = $areaCode;
        $customer->save();

        session(["message_success" => "Pelanggan baru berhasil ditambahkan"]);
        return redirect('pelanggan');
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

    public function getCustomerById($no_pelanggan)
    {
        $customer = Customer::with(['kategori'])->where("no_pelanggan", $no_pelanggan)->first();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        $categories = Category::all();

        return view('customer.form', compact('customer', 'categories'));
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

        $customer = Customer::find($id);
        $customer->no_pelanggan = $request->input('no_pelanggan');
        $customer->kategori_bangunan_id = $request->input('kategori_bangunan_id');
        $customer->nik = $request->input('nik');
        $customer->nama_lengkap = $request->input('nama_lengkap');
        $customer->alamat = $request->input('alamat');
        $customer->kode_area = $areaCode;
        $customer->save();

        session(["message_success" => "Data pelanggan berhasil diperbaharui"]);
        return redirect('pelanggan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        session(["message_success" => "Data pelanggan berhasil dihapus"]);
        return redirect('pelanggan');
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        session(["message_success" => "Data pelanggan berhasil dihapus"]);
        return redirect('pelanggan');
    }
}
