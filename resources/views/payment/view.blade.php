@extends('layouts.app')
@section('title', 'digiPamsimas - Pembayaran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pembayaran /</span> Loket Pembayaran</h4>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h5>Loket Pembayaran</h5>
                {{-- <a href="{{ route('pembayaran.create') }}" class="btn btn-primary ms-auto">Tambah Pembayaran</a> --}}
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal-dialog" class="btn btn-primary ms-auto" title="Tambah Data" data-class="modal-lg" data-title="Tambah Catat Meter" data-url="{{ route('catat_meter.create') }}" onclick="loadModal(this)">Tambah Catat Meter</button>    
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
                            <th>Angka Meter</th>
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
                                <td>{{ $payment->catat_meter->pelanggan->nama_lengkap }}<br>{{ $payment->catat_meter->pelanggan->nik }}</td>
                                <td class="text-center">{{ $payment->catat_meter->angka_meter . " (" . $payment->catat_meter->volume . " m3)" }}</td>
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
<script>
    function searchCustomer(id){
        let input = document.getElementById(id).value;
        let inputCustomerNumber = document.getElementById('input-no-pelanggan');

        let data = input.split('-');

        checkRecordMeter(data[0]);
        inputCustomerNumber.value = data[0];
    }

    function checkRecordMeter(no){
        let rows = document.querySelectorAll('.row-catat-meter');
        $.ajax({
            url: `//${window.location.hostname}/catat_meter/cek/${no}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                let data = response.data;

                if (data == null) {
                    getPrevMonthPayment(no);

                    rows.forEach(function(element){
                        element.classList.remove('d-none');
                    });
                } else {
                    $('#modal-dialog').modal('hide');
                    let bulan = data.bulan - 1;
                    let date = new Date(data.tahun, bulan, 1)

                    let monthName = date.toLocaleString('id-ID', {month: 'long'});
                    alertModal(`Pelanggan sudah di catat meter untuk bulan ${monthName}`, 'danger');
                }
            }
        });
    }

    function getPrevMonthPayment(no){
        let label = document.getElementById('label-bulan-sebelumnya');
        let input = document.getElementById('input-angka-meter-bulan-sebelumnya');

        $.ajax({
            url: `//${window.location.hostname}/catat_meter/bulan_sebelumnya/${no}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if (response.data != null) {
                    let data = response.data;
                    let bulan = data.bulan - 1;
                    let date = new Date(data.tahun, bulan, 1)

                    label.innerHTML = date.toLocaleString('id-ID', {month: 'long'});
                    input.value = data.angka_meter;
                } 
            }
        });
    }

    function calculateVolume(e){
        let input1 = e.value;
        let input2 = document.getElementById('input-angka-meter-bulan-sebelumnya').value;
        let inputVolume = document.getElementById('input-volume-air');

        let volumeValue = input1 - input2;
        inputVolume.value = volumeValue;
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
</script>
@endsection
