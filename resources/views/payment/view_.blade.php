@extends('layouts.app')
@section('title', 'digiPamsimas - Pembayaran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pembayaran /</span> Data Pembayaran</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Pembayaran</h5>
                <a href="{{ route('pembayaran.create') }}" class="btn btn-primary ms-auto">Tambah Pembayaran</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>No. Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Posisi Meter</th>
                            <th>Total Tagihan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $payment->no_transaksi }}</td>
                                <td>{{ $payment->pelanggan->nama_lengkap }}<br>{{ $payment->pelanggan->nik }}</td>
                                <td class="text-center">{{ $payment->posisi_meter . " (" . $payment->volume . " m3)" }}</td>
                                <td class="text-end">Rp. {{ number_format($payment->total_tagihan, 0, ",", ".") }}</td>
                                <td class="text-center"><span class="badge bg-success">Lunas</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="bx bx-info-circle me-1"></i> Detail</a>
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
