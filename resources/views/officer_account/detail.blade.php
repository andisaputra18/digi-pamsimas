@extends('layouts.app')
@section('title', 'digiPamsimas - Akun Petugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan / Data Akun Petugas / </span> Akun</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Akun Petugas</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog" class="btn btn-primary ms-auto" title="Tambah Data" data-class="modal-md" data-title="Tambah Akun Petugas" data-url="{{ url("akun_petugas/add/$partner->id") }}" onclick="loadModal(this)">Tambah Akun Petugas</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">

            </div>
        </div>
    </div>
</div>
@endsection
