@extends('layouts.app')
@section('title', 'digiPamsimas - Akun Pengguna')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan / Pengguna /</span> Tambah Pengguna</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Form Tambah Pengguna</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('pengguna.store') }}">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="select-mitra-pengguna">Mitra</label>
                    <div class="col-sm-10">
                        <select name="kode_area" id="select-mitra-pengguna" class="form-select">
                            <option value="">Pilih Mitra</option>
                            @foreach ($partners as $partner)
                                @php
                                    $selected = "";
                                    if (isset($user)) {
                                        $selected = $user->kode_area == $partner->kode_area ? "selected" : "";
                                    }
                                @endphp
                               <option value="{{ $partner->kode_area }}" {{ $selected }}>{{ $partner->nama_pamsimas }} - {{ "Desa " . $partner->wilayah }} Kecamatan {{ $partner->kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="select-group-pengguna">Group</label>
                    <div class="col-sm-10">
                        <select name="user_group_id" id="select-group-pengguna" class="form-select">
                            <option value="">Pilih User Group</option>
                            @foreach ($groups as $group)
                                @php
                                $selected = "";
                                if (isset($user)) {
                                    $selected = $user->user_group_id == $group->id ? "selected" : "";
                                }
                                @endphp
                                <option value="{{ $group->id }}" {{ $selected }}>{{ $group->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="input-username-pengguna">Username</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" id="input-username-pengguna" placeholder="Username" value="{{ isset($user) ? $user->username : "" }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="input-password-pengguna">Password</label>
                    <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="input-password-pengguna" placeholder="Password" />
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
