@extends('layouts.app')
@section('title', 'digiPamsimas - Pelanggan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pelanggan / Form /</span> {{ isset($customer) ? "Ubah" : "Tambah" }} Pelanggan</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Form {{ isset($customer) ? "Ubah" : "Tambah" }} Pelanggan</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ isset($customer) ? route('pelanggan.update', $customer->id) : route('pelanggan.store') }}">
                @csrf
                @if (isset($customer))
                    @method('PUT')
                @endif
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="input-no-pelanggan">No. Pelanggan</label>
                    <div class="col-sm-10">
                    <input type="text" name="no_pelanggan" class="form-control" id="input-no-pelanggan" placeholder="Nomor Pelanggan" maxlength="10" value="{{ isset($customer) ? $customer->no_pelanggan : "" }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="select-kategori-pelanggan">Kategori Bangunan</label>
                    <div class="col-sm-10">
                        <select name="kategori_bangunan_id" id="select-kategori-pelanggan" class="form-select">
                            <option value="">Pilih Kategori Bangunan</option>
                            @foreach ($categories as $category)
                                @php
                                    $selected = "";
                                    if (isset($customer)) {
                                        $selected = $customer->kategori_bangunan_id == $category->id ? "selected" : "";
                                    }
                                @endphp
                                <option value="{{ $category->id }}" {{ $selected }}>{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="input-nik-pelanggan">NIK</label>
                    <div class="col-sm-10">
                    <input type="text" name="nik" class="form-control" id="input-nik-pelanggan" placeholder="Nomor Induk Kependudukan" maxlength="16" value="{{ isset($customer) ? $customer->nik : "" }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama-lengkap-pelanggan">Nama Lengkap</label>
                    <div class="col-sm-10">
                    <input type="text" name="nama_lengkap" class="form-control" id="nama-lengkap-pelanggan" placeholder="Nama Lengkap" value="{{ isset($customer) ? $customer->nama_lengkap : "" }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="alamat-pelanggan">Alamat</label>
                    <div class="col-sm-10">
                    <textarea id="alamat-pelanggan" name="alamat" class="form-control" placeholder="Alamat Lengkap">{{ isset($customer) ? $customer->alamat : "" }}</textarea>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
