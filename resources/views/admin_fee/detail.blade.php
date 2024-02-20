@extends('layouts.app')
@section('title', 'digiPamsimas - Biaya Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan / Biaya Admin </span> Detail</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Detail Biaya Admin</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog" class="btn btn-primary ms-auto" data-class="modal-md" data-title="Tambah Mitra Biaya Admin" data-url="{{ url('biaya_admin/mitra/tambah/' . $fee->id) }}" onclick="loadModal(this)">Tambah Mitra Biaya Admin</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($feePartners as $feePartner)
                    <div class="col-lg-3">
                        <ul class="list-group">
                            <li class="list-group-item fw-bold">
                                Mitra {{ $loop->iteration }}</li>
                            <li class="list-group-item text-center">
                                {{ $feePartner->mitra->nama_pamsimas }} <br>
                                {{ "Desa " . $feePartner->mitra->wilayah  }}
                            </li>
                            <li class="list-group-item text-end">
                                <a href="{{ url('biaya_admin/hapus_mitra/' . $feePartner->mitra->kode_area) }}" class="btn btn-sm btn-danger" onclick="confirmDelete(this, 'Anda akan menghapus mitra biaya admin');event.preventDefault();"><i class="bx bx-trash"></i></a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
