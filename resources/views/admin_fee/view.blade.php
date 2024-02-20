@extends('layouts.app')
@section('title', 'digiPamsimas - Biaya Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Biaya Admin</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Biaya Admin</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog" class="btn btn-primary ms-auto" title="Tambah Data" data-class="modal-md" data-title="Tambah Biaya Admin" data-url="{{ route('biaya_admin.create') }}" onclick="loadModal(this)">Tambah Biaya Admin</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($fees as $fee)
                    <div class="col-lg-3">
                        <ul class="list-group">
                            <li class="list-group-item fw-bold">Biaya Admin {{ $loop->iteration }}</li>
                            <li class="list-group-item">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Biaya</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($fee->biaya, 0, ",", ".") }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Mitra</td>
                                            <td>:</td>
                                            <td>{{ count($fee->mitra) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </li>
                            <li class="list-group-item">
                                <div class="float-end">
                                    <a href="{{ route('biaya_admin.show', $fee->id) }}" class="badge badge-center rounded-pill bg-primary text-white"><i class="bx bx-arrow-from-left"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
