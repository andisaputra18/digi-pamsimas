@extends('layouts.app')
@section('title', 'digiPamsimas - Pelanggan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pelanggan /</span> Data Pelanggan</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Pelanggan</h5>
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary ms-auto">Tambah Pelanggan</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>No. Pelanggan</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $customer->no_pelanggan }}</td>
                                <td>{{ $customer->nik }}</td>
                                <td>{{ $customer->nama_lengkap }}</td>
                                <td>{{ $customer->alamat }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('pelanggan.edit', $customer->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a href="{{ url('pelanggan/delete/' . $customer->id) }}" class="dropdown-item" onclick="confirmDelete(this, 'Anda akan menghapus pelanggan a.n {{ $customer->nama_lengkap }}');event.preventDefault();"><i class="bx bx-trash me-1"></i> Hapus</a>
                                            {{-- <form action="{{ url('pelanggan/destroy/' . $customer->nama_lengkap) }}" method="post" id="form-delete-data">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="confirmDelete(this, 'Anda akan menghapus pelanggan a.n {{ $customer->nama_lengkap }}');event.preventDefault();" class="dropdown-item"><i class="bx bx-trash me-1"></i> Hapus</button>
                                            </form> --}}
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
