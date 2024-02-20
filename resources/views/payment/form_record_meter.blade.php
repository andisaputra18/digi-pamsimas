<form action="{{ route('catat_meter.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xxl">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="select-pelanggan-pembayaran">Pelanggan</label>
                <div class="col-sm-8">
                    <input list="pelanggan" id="select-pelanggan-pembayaran" class="form-select" placeholder="Cari NIK / Nama Lengkap Pelanggan">
                    <datalist id="pelanggan">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->no_pelanggan . " - " . $customer->nama_lengkap . " - " . $customer->alamat }}">{{ $customer->no_pelanggan }} - {{ $customer->nama_lengkap . " " . $customer->alamat }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-info" onclick="searchCustomer('select-pelanggan-pembayaran')"><i class="bx bx-search"></i> Cari</button>
                </div>
                <hr class="mt-3">
            </div>
            <input type="hidden" name="no_pelanggan" class="form-control" id="input-no-pelanggan">
            <div class="row mb-3 row-catat-meter d-none">
                <label class="col-sm-2 col-form-label">Bulan <span id="label-bulan-sebelumnya"></span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control col-lg-4" id="input-angka-meter-bulan-sebelumnya" placeholder="Angka meter bulan sebelumnya" readonly>
                </div>
            </div>
            <div class="row mb-3 row-catat-meter d-none">
                <label class="col-sm-2 col-form-label">Angka Meter</label>
                <div class="col-sm-10">
                    <input type="number" name="angka_meter" class="form-control" placeholder="Angka meter bulan ini" id="input-angka-meter" onkeyup="calculateVolume(this)">
                </div>
            </div>
            <div class="row mb-3 row-catat-meter d-none">
                <label class="col-sm-2 col-form-label">Volume Air</label>
                <div class="col-sm-10">
                    <input type="text" name="volume" id="input-volume-air" class="form-control" placeholder="Volume air (m3)" readonly>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary row-catat-meter d-none">Kirim</button>
    </div>
</form>