@extends('layouts.app')
@section('title', 'digiPamsimas - Petugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Data Petugas</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Petugas</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog" class="btn btn-primary ms-auto" title="Tambah Data" data-class="modal-lg" data-title="Tambah Data Petugas" data-url="{{ url("petugas/add/$partner->id") }}" onclick="loadModal(this)">Tambah Data Petugas</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Petugas</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($officers as $officer)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $officer->nama_lengkap }}<br>{{ $officer->nik }}</td>
                                <td>{{ $officer->jenis_kelamin == "L" ? "Laki-Laki" : "Perempuan" }}</td>
                                <td>{{ $officer->no_telpon }}</td>
                                <td>{{ $officer->alamat }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog" class="dropdown-item" title="Uba Data" data-class="modal-lg" data-title="Ubah Data Petugas" data-url="{{ route('petugas.edit', $officer->id) }}" onclick="loadModal(this)"><i class="bx bx-edit-alt me-1"></i> Edit</button>
                                            <a href="{{ url("petugas/delete/$officer->id") }}" class="dropdown-item" onclick="confirmDelete(this, 'Anda akan menghapus petugas a.n {{ $officer->nama_lengkap }}');event.preventDefault();"><i class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
