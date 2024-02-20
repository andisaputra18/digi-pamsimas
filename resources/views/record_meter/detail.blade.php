@extends('layouts.app')
@section('title', 'digiPamsimas - Pembayaran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pembayaran /</span> Rincian Pembayaran</h4>

    <form action="{{ route('pembayaran.store') }}" method="POST">
        @csrf
        <div class="row row-pembayaran">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold">Profil Pelanggan</span>
                            <span id="label-kategori" class="ms-auto badge bg-secondary">{{ $record->pelanggan->kategori->nama }}</span>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body" style="margin-top: -16px;">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">No. Pelanggan</label>
                            <div class="col-sm-8">
                                <span id="no-pelanggan">{{ $record->pelanggan->no_pelanggan }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-8">
                                <span id="nama-lengkap-pelanggan">{{ $record->pelanggan->nama_lengkap . "(" . $record->pelanggan->nik . ")" }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <span id="alamat-pelanggan">{{ $record->pelanggan->alamat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold">Pembayaran Bulan <span id="title-bulan-sebelumnya"></span></span>
                        <hr>
                    </div>
                    <div class="card-body" style="margin-top: -16px;">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Angka Meter</label>
                            <div class="col-sm-8">
                                <span id="posisi-meter-sebelumnya">{{ $last_record->angka_meter }} {{ "(" . $last_record->volume . " m3)"}}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Total Tagihan</label>
                            <div class="col-sm-8">
                                <span id="total-tagihan-sebelumnya">Rp. {{ number_format($last_record->pembayaran->total_tagihan, 0, ",", ".") }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <span id="keterangan-sebelumnya" class="badge bg-success">Lunas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 row-pembayaran">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold">Catat Pembayaran Bulan <span id="title-bulan-sekarang"></span></span>
                        <hr>
                    </div>
                    <div class="card-body" style="margin-top: -16px;">
                        <div class="row mb-3">
                            <label class="col-sm-7 col-form-label">Posisi Meter</label>
                            <div class="col-sm-5">
                                <div class="float-end">
                                    <input type="number" name="posisi_meter" class="form-control" placeholder="Posisi Meter " id="input-posisi-meter" readonly value="{{ $record->angka_meter }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-7 col-form-label">Volume Air</label>
                            <div class="col-sm-5">
                                <div class="float-end">
                                    <input type="text" name="volume" id="input-volume-air" readonly value="{{ $record->volume . " m3" }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold">Rincian Pembayaran</span>
                        <hr>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" style="margin-top: -20px;">
                            <tbody>
                                <tr>
                                    <td>Biaya Abodemen</td>
                                    <td class="text-end">Rp. {{ number_format($setting->biaya_abodemen, 0, ",", ".") }}</td>
                                </tr>
                                <tr>
                                    <td>Biaya Tagihan</td>
                                    <td class="text-end">
                                        @php
                                            $biaya = json_decode($setting->biaya);
                                            foreach ($biaya as $key => $item) {
                                                $sub_total = (int) $record->volume * (int) $item->tarif;
                                                echo $record->volume . " x Rp. " . number_format($item->tarif, 0, ",", ".") . " = Rp. " . number_format($sub_total, 0, ",", ".");
                                            }  
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biaya Admin</td>
                                    <td class="text-end">Rp. {{ number_format($fee_admin->biaya->biaya, 0, ",", ".") }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Tagihan</td>
                                    <td class="text-end fw-bold">
                                        @php
                                            $total = (int) $setting->biaya_abodemen + $sub_total + (int) $fee_admin->biaya->biaya
                                        @endphp
                                        {{ "Rp. " . number_format($total, 0, ",", ".") }}
                                        <input type="hidden" value="{{ $total }}" id="input-total-tagihan">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mb-3 mt-3">
                            <label class="col-sm-6 col-form-label text-end">Uang yang di bayarkan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control input-number" placeholder="Jumlah Uang" id="uang-dibayarkan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="float-end">
                                    {{-- <button type="button" class="btn btn-info" onclick="calculateChange()">Bayar</button> --}}
                                    <button type="button" class="btn btn-info" onclick="showModal()">Bayar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-2 d-none" id="row-jumlah-kembalian">
                            <label class="col-sm-6 col-form-label text-end fw-bold">Jumlah Kembalian</label>
                            <div class="col-sm-6">
                                <div class="float-end">
                                    <span id="jumlah-kembalian" class="fw-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="float-end">
                    <button type="submit" class="btn btn-primary mt-3 row-pembayaran d-none">Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal-payment-success" tabindex="-1" role="dialog" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title w-100">Pembayaran Berhasil</h5>
                {{-- <button type="button" class="btn-close btn-dark" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <form action="{{ route('pembayaran.store') }}" method="post">
                            @csrf
                            <i class="bx bxs-check-shield text-success" style="font-size: 80px;"></i><br>
                            <h4>Uang Kembalian : </h4><br>
                            <h2 id="uang-kembalian"></h2><br>
                            <input type="hidden" name="catat_meter_id" value="{{ $record->id }}">
                            <input type="hidden" name="tgl_pembayaran" value="{{ date('Y-m-d') }}" >
                            <input type="hidden" name="total_tagihan" value="{{ $total }}">
                            <input type="hidden" name="uang_dibayarkan" placeholder="Jumlah Uang" id="input-uang-dibayarkan">
                            <button type="submit" class="btn btn-primary">Simpan Transaksi & Cetak Tagihan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        }).format(number);
    }

    function alertModal(title, color){
        let confirm = color == 'danger' ? '#d33' : '#33a4dd';

        Swal.fire({
            title: title,
            icon: 'warning',
            confirmButtonColor: confirm,
            confirmButtonText: "Tutup",
            reverseButtons: true
        });
    }

    function showModal(){
        let money = document.getElementById('uang-dibayarkan');
        let inputMoney = document.getElementById('input-uang-dibayarkan');
        let inputTotal = document.getElementById('input-total-tagihan');
        let changeMoney = document.getElementById('uang-kembalian');

        let change = money.value.replace(".", "");
        let valueChangeMoney = change - inputTotal.value;

        if (money.value == "") {
            alertModal("Input uang dibayarkan wajib di isi!", "danger");
        } else {
            if (change < inputTotal.value) {
                alertModal("Jumlah uang dibayarkan harus lebih besar dari total tagihan!", "danger");
            } else {
                $('#modal-payment-success').modal('show');

                inputMoney.value = money.value;
                changeMoney.innerHTML = rupiah(valueChangeMoney);
            }
        }
    }

</script>
@endsection
