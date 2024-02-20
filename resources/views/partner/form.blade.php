@extends('layouts.app')
@section('title', 'digiPamsimas - Mitra')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Mitra / Form /</span> {{ isset($partner) ? "Ubah" : "Tambah" }} Mitra</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Form {{ isset($partner) ? "Ubah" : "Tambah" }} Mitra</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ isset($partner) ? route('mitra.update', $partner->id) : route('mitra.store') }}">
                @csrf
                @isset($partner)
                    @method('PUT')
                @endisset
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="input-nama-pamsimas-mitra">Nama Pamsimas</label>
                <div class="col-sm-10">
                  <input type="text" name="nama_pamsimas" class="form-control" id="input-nama-pamsimas-mitra" placeholder="Nama Pamsimas" value="{{ isset($partner) ? $partner->nama_pamsimas : "" }}" />
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="input-wilayah-mitra">Wilayah</label>
                <div class="col-sm-10">
                    <select name="provinsi" id="select-province" class="form-select region" required onchange="loadChildForRegion(this, 'select-regency')">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinces as $key => $province)
                            @php
                                $selected = "";
                                if(isset($partner)){
                                    $selected = $partner->provinsi == $province->name ? "selected" : "";
                                }
                            @endphp
                            <option value="{{ $province->id }}" {{ $selected }}>{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select name="kabupaten" id="select-regency" class="form-select region mt-2" onchange="loadChildForRegion(this, 'select-district')">
                        <option value="">Pilih Kabupaten/Kota</option>
                        @isset($partner)
                            @foreach ($regencies as $regency)
                                <option value="{{ $regency->id }}" {{ $partner->kabupaten == $regency->name ? "selected" : "" }}>{{ $regency->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                    <select name="kecamatan" id="select-district" class="form-select region mt-2" onchange="loadChildForRegion(this, 'select-village')">
                        <option value="">Pilih Kecamatan</option>
                        @isset($partner)
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ $partner->kecamatan == $district->name ? "selected" : "" }}>{{ $district->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                    <select name="kode_area" id="select-village" class="form-select region mt-2" required>
                        <option value="">Pilih Desa/Kelurahan</option>
                        @isset($partner)
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}" {{ $partner->wilayah == $village->name ? "selected" : "" }}>{{ $village->name }}</option>
                            @endforeach
                        @endisset
                    </select>
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
