@extends('layouts.app')
@section('title', 'digiPamsimas - Akun Pengguna')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Akun Pengguna</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Pengguna</h5>
                <a href="{{ route('pengguna.create') }}" class="btn btn-primary ms-auto">Tambah Pengguna</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Mitra</th>
                            <th>Group</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>Desa {{ $user->mitra->wilayah }}</td>
                                <td>{{ $user->group->nama }}</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('pengguna.edit', $user->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a href="{{ route('pengguna.destroy', $user->id) }}" class="dropdown-item" onclick="confirmDelete(this, 'Anda akan menghapus akun pengguna {{ $user->group->nama }}');event.preventDefault();"><i class="bx bx-trash me-1"></i> Delete</a>
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
