@extends('layouts.app')
@section('title', 'digiPamsimas - Mitra')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Mitra /</span> Data Mitra</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Mitra</h5>
                <a href="{{ route('mitra.create') }}" class="btn btn-primary ms-auto">Tambah Mitra</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Pamsimas</th>
                            <th>Desa</th>
                            <th>Kecamatan</th>
                            <th>Kabupaten</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($partners as $partner)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $partner->nama_pamsimas }}</td>
                                <td>{{ $partner->wilayah }}</td>
                                <td>{{ $partner->kecamatan }}</td>
                                <td>{{ $partner->kabupaten }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('mitra.edit', $partner->id) }}"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                                            <a class="dropdown-item" href="{{ url('mitra/delete/' . $partner->id) }}" onclick="confirmDelete(this, 'Anda akan menghapus mitra {{ $partner->nama_pamsimas }}');event.preventDefault()"><i class="bx bx-trash me-1"></i>Delete</a>
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
