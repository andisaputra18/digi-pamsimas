@extends('layouts.app')
@section('title', 'digiPamsimas - Akun Petugas')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Data Akun Petugas</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Mitra</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($partners as $partner)
                <div class="col-lg-3">
                    <a href="{{ route('akun_petugas.show', $partner->id) }}">
                        <ul class="list-group">
                            <li class="list-group-item fw-bold">Mitra</li>
                            <li class="list-group-item">
                                <span>{{ $partner->nama_pamsimas }}</span><br>
                                <span>Desa {{ $partner->wilayah }}</span><br>
                                <span>Jumlah Petugas : {{ $partner->petugas_count }}</span>
                            </li>
                        </ul>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
