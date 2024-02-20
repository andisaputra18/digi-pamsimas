@extends('layouts.app')
@section('title', 'digiPamsimas - Setting Biaya')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Setting Pembayaran /</span> Data Settingan Pembayaran</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Data Settingan Pembayaran</h5>
                <a href="{{ route('rumus.create') }}" class="btn btn-primary ms-auto">Tambah Settingan</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($settings as $setting)
                    <div class="col-lg-4">
                        <ul class="list-group">
                            <li class="list-group-item fw-bold">
                                <div class="d-flex align-items-center">
                                    {{ $setting->category->nama }}
                                    @php
                                        $bg_badge = $setting->status == 1 ? "bg-success" : "bg-warning";
                                    @endphp
                                    <span class="badge {{ $bg_badge }} ms-auto"><i class="bx bx-badge-check"></i></span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Biaya Abodemen</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($setting->biaya_abodemen, 0, ",", ".") }}</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td>{{ $setting->pengaturan_biaya == 1 ? "Sekali Biaya" : "Rentang Biaya" }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </li>
                            <li class="list-group-item">
                                @php
                                    $biaya = json_decode($setting->biaya);
                                @endphp
                                <table>
                                    <tbody>
                                        @foreach ($biaya as $key => $item)
                                        @php
                                            $angka_akhir = $item->angka_akhir == 99 ? "(~)" : $item->angka_akhir;
                                        @endphp
                                            <tr>
                                                <td>Angka Meter {{ $loop->iteration }}</td>
                                                <td>:</td>
                                                <td>{{ $item->angka_awal . " - " . $angka_akhir . " m3 = Rp. " . number_format($item->tarif, 0, ",", ".")}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </li>
                            <li class="list-group-item">
                                <div class="float-end">
                                    <a href="{{ route('rumus.edit', $setting->id) }}" class="btn btn-sm btn-info"><i class="bx bx-edit"></i></a>
                                    <a href="{{ url('rumus/delete/' . $setting->id) }}" class="btn btn-sm btn-danger" onclick="confirmDelete(this, 'Anda akan menghapus data settingan biaya');event.preventDefault();"><i class="bx bx-trash"></i></a>
                                    <a href="{{ url('rumus/status/' . $setting->id) }}" class="btn btn-sm btn-secondary" onclick="confirmDialog(this, 'Anda akan merubah status menjadi {{ $setting->status == 1 ? 'Tidak Aktif' : 'Aktif' }}');event.preventDefault();"><i class="bx bx-toggle-right"></i></a>
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
