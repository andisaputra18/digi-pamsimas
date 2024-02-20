@extends('layouts.app')
@section('title', 'digiPamsimas - Pembayaran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Pembayaran / Form /</span> Catatan Pembayaran</h4>

    <form action="{{ route('pembayaran.store') }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-xxl">
            <div class="card mb-4">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Form Catat Pembayaran</h5>
              </div>
              <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="select-pengguna-pembayaran">Pelanggan</label>
                        <div class="col-sm-8">
                            <input list="pelanggan" id="select-pelanggan-pembayaran" class="form-select" placeholder="Cari NIK / Nama Lengkap Pelanggan">
                            <datalist id="pelanggan">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->no_pelanggan . " - " . $customer->nama_lengkap . " - " . $customer->alamat }}">{{ $customer->no_pelanggan }} - {{ $customer->nama_lengkap . " " . $customer->alamat }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-primary" onclick="searchCustomer('select-pelanggan-pembayaran')"><i class="bx bx-search"></i> Cari</button>
                        </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row row-pembayaran d-none">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold">Profil Pelanggan</span>
                            <span id="label-kategori" class="ms-auto"></span>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body" style="margin-top: -16px;">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">No. Pelanggan</label>
                            <div class="col-sm-8">
                                <span id="no-pelanggan"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-8">
                                <span id="nama-lengkap-pelanggan"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <span id="alamat-pelanggan"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold">Pembayaran Bulan <span id="title-bulan-sebelumnya">{Kemaren}</span></span>
                        <hr>
                    </div>
                    <div class="card-body" style="margin-top: -16px;">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Posisi Meter</label>
                            <div class="col-sm-8">
                                <span id="posisi-meter-sebelumnya"></span>
                                <input type="text" class="form-control d-none" id="input-posisi-meter-bulan-kemaren" placeholder="Posisi meter bulan kemaren (m3)">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Total Tagihan</label>
                            <div class="col-sm-8">
                                <span id="total-tagihan-sebelumnya"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <span id="keterangan-sebelumnya"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 row-pembayaran d-none">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <span class="fw-bold">Catat Pembayaran Bulan <span id="title-bulan-sekarang"></span></span>
                        <hr>
                    </div>
                    <div class="card-body" style="margin-top: -16px;">
                        <div class="row mb-3">
                            <label class="col-sm-5 col-form-label">Posisi Meter</label>
                            <div class="col-sm-7">
                                <input type="number" name="posisi_meter" class="form-control" placeholder="Posisi Meter " id="input-posisi-meter" onkeyup="calculateVolume(this)">
                            </div>
                            {{-- <div class="col-lg-3">
                                <button type="button" class="btn btn-info" id="button-calculate" onclick="calculate()">Hitung</button>
                                <div class="float-end">
                                </div>
                            </div> --}}
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-5 col-form-label">Volume Air</label>
                            <div class="col-sm-7">
                                <div class="float-end">
                                    <span id="volume-air"></span>
                                    <input type="hidden" name="volume" id="input-volume-air">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="float-end">
                                    <button type="button" class="btn btn-info" id="button-calculate" onclick="calculate()">Hitung</button>
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
                        <input type="hidden" name="pelanggan_id" id="id-pelanggan">
                        <input type="hidden" name="no_pelanggan" id="input-no-pelanggan">
                        <input type="hidden" name="setting_biaya_id" id="id-setting-biaya">
                        <input type="hidden" id="input-abodemen">
                        <input type="hidden" id="input-biaya-admin" value="{{ floatval($fee_admin->biaya->biaya) }}">
                        <input type="hidden" name="total_tagihan" id="input-total-tagihan">

                        <table class="table table-bordered" style="margin-top: -20px;">
                            <tbody>
                                <tr>
                                    <td>Biaya Abodemen</td>
                                    <td class="text-end"><span id="biaya-abodemen" class="d-none"></span></td>
                                </tr>
                                <tr>
                                    <td>Biaya Tagihan</td>
                                    <td><span id="biaya-tagihan"></span>
                                        <div class="float-end">
                                            <span id="sub-biaya-tagihan"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biaya Admin</td>
                                    <td class="text-end">
                                        <span id="biaya-admin" class="d-none">Rp. {{ number_format($fee_admin->biaya->biaya, 0, ",", ".") }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Tagihan</td>
                                    <td class="text-end fw-bold">
                                        <span id="total-tagihan"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mb-3 mt-3">
                            <label class="col-sm-6 col-form-label text-end">Uang yang di bayarkan</label>
                            <div class="col-sm-6">
                                <input type="text" name="uang_dibayarkan" class="form-control input-number" placeholder="Jumlah Uang" id="uang-dibayarkan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="float-end">
                                    <button type="button" class="btn btn-success" onclick="calculateChange()">Bayar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-2">
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
<script>
    function searchCustomer(id){
        let input = document.getElementById(id).value;

        let data = input.split('-');
        checkPayment(data[0]);
    }

    function checkPayment(no){
        $.ajax({
            url: `//${window.location.hostname}/pembayaran/cek_pembayaran/${no}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                let data = response.data;

                if (data == 1) {
                    alertModal('Pelanggan sudah melakukan pembayaran', 'danger');
                } else {
                    showProfileCustomer(no);
                    getPrevMonthPayment(no);
                    getSettingBiaya(no);
                }
            }
        });
    }

    function showProfileCustomer(no){
        let rows = document.querySelectorAll('.row-pembayaran');
        let labelCategory = document.getElementById('label-kategori');
        let labelMonth = document.getElementById('title-bulan-sekarang');
        let id = document.getElementById('id-pelanggan');
        let number = document.getElementById('no-pelanggan');
        let inputNumberCustomer = document.getElementById('input-no-pelanggan');
        let name = document.getElementById('nama-lengkap-pelanggan');
        let address = document.getElementById('alamat-pelanggan');

        rows.forEach(function(element){
            element.classList.remove('d-none');
        });

        const date = new Date();
        labelMonth.innerHTML = date.toLocaleString('id-ID', {month: 'long'});

        $.ajax({
            url: `//${window.location.hostname}/pelanggan/profil/${no}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                let data = response.data;

                labelCategory.innerHTML = `<span class="badge bg-secondary">${data.kategori.nama}</span>`;
                id.value = data.id;
                number.innerHTML = data.no_pelanggan;
                inputNumberCustomer.value = data.no_pelanggan;
                name.innerHTML = data.nama_lengkap + " (" + data.nik + ")";
                address.innerHTML = data.alamat;
            }
        });
    }

    function getPrevMonthPayment(no){
        let title = document.getElementById('title-bulan-sebelumnya');
        let input = document.getElementById('input-posisi-meter-bulan-kemaren');
        let posisi = document.getElementById('posisi-meter-sebelumnya');
        let tagihan = document.getElementById('total-tagihan-sebelumnya');
        let keterangan = document.getElementById('keterangan-sebelumnya');

        $.ajax({
            url: `//${window.location.hostname}/pembayaran/bulan_sebelumnya/${no}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                if (response.data != null) {
                    let data = response.data;
                    let bulan = data.bulan - 1;
                    let date = new Date(data.tahun, bulan, 1)

                    title.innerHTML = date.toLocaleString('id-ID', {month: 'long'});
                    posisi.innerHTML = data.posisi_meter + " m3";
                    input.value = data.posisi_meter;
                    input.classList.add('d-none');
                    tagihan.innerHTML = rupiah(data.total_tagihan);
                    keterangan.innerHTML = "<span class='badge bg-success'>Lunas</span>";
                } else {
                    input.classList.remove('d-none');
                    tagihan.innerHTML = "-";
                    keterangan.innerHTML = "-";
                }

            }
        });
    }

    function getSettingBiaya(no){
        let inputSetting = document.getElementById('id-setting-biaya');
        let input = document.getElementById('input-abodemen');
        let span = document.getElementById('biaya-abodemen');

        $.ajax({
            url: `//${window.location.hostname}/rumus/biaya/${no}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
                let data = response.data;

                inputSetting.value = data.id;
                let abodemen = parseFloat(data.biaya_abodemen);
                input.value = abodemen;
                span.innerHTML = rupiah(abodemen);
            }
        });
    }

    function calculateVolume(e){
        let input1 = e.value;
        let input2 = document.getElementById('input-posisi-meter-bulan-kemaren').value;
        let volume = document.getElementById('volume-air');
        let inputVolume = document.getElementById('input-volume-air');

        let volumeValue = input1 - input2;
        volume.innerHTML = volumeValue + " m3";
        inputVolume.value = volumeValue;
    }

    function calculate(){
        let formulaId = document.getElementById('id-setting-biaya').value;
        let volume = document.getElementById('input-volume-air').value;
        let inputPosisiMeter = document.getElementById('input-posisi-meter').value;
        let labelAbodemen = document.getElementById('biaya-abodemen');
        let abodemen = document.getElementById('input-abodemen').value;
        let labelFeeAdmin = document.getElementById('biaya-admin');
        let feeAdmin = document.getElementById('input-biaya-admin').value;
        let bill = document.getElementById('biaya-tagihan');
        let subInvoice = document.getElementById('sub-biaya-tagihan');
        let invoice = document.getElementById('total-tagihan');
        let inputInvoice = document.getElementById('input-total-tagihan');

        if (inputPosisiMeter == "") {
            alertModal("Posisi meter wajib di isi!", "danger");
        } else {
            let cost = getFormula(formulaId, volume);
            labelAbodemen.classList.remove('d-none');
            labelFeeAdmin.classList.remove('d-none');
            bill.innerHTML = volume + " x " + rupiah(cost) + " = ";
            let subtotal = (volume * cost) + parseInt(abodemen);
            subInvoice.innerHTML = rupiah(subtotal);

            let total = subtotal + parseFloat(feeAdmin);
            invoice.innerHTML = rupiah(total);
            inputInvoice.value = total;
        }

    }

    function getFormula(id, volume){
        let cost = "";

        $.ajax({
            url: `//${window.location.hostname}/rumus/cek/${id}`,
            type: 'GET',
            dataType: 'JSON',
            async: false,
            success: function(response){
                let data = response.data;
                let fee = JSON.parse(data.biaya);

                let costs = "";
                fee.forEach(function(element){
                    if (parseInt(volume) >= parseInt(element.angka_awal) && parseInt(volume) <= parseInt(element.angka_akhir)) {
                        costs = element.tarif;
                    }
                });
                cost = costs;
            }
        });

        return cost;
    }

    function calculateChange(){
        let input = document.getElementById('uang-dibayarkan');
        let inputInvoice = document.getElementById('input-total-tagihan');
        let change = document.getElementById('jumlah-kembalian');

        let money = input.value.replace(".", "");
        let changeMoney = money - inputInvoice.value;

        if (input.value == "") {
            alertModal("Input uang dibayarkan wajib di isi!", "danger");
        } else {
            if (money < inputInvoice.value) {
                console.log(money)
                console.log(inputInvoice.value)
                alertModal("Jumlah uang dibayarkan harus lebih besar dari total tagihan!", "danger");
            } else {
                change.innerHTML = rupiah(changeMoney);
            }
        }

    }

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

</script>
@endsection
