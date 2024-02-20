<form method="POST" action="{{ isset($officer) ? route('petugas.update', $officer->id) : route('petugas.store') }}">
    @csrf
    @isset($officer)
        @method('PUT')
    @endisset
    <input type="hidden" name="mitra_id" value="{{ $partner->id }}">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-nik-pengguna">NIK</label>
        <div class="col-sm-9">
            <input type="text" name="nik" class="form-control" id="input-nik-pengguna" placeholder="Nomor Induk Kependudukan" maxlength="16" value="{{ isset($officer) ? $officer->nik : "" }}" />
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-nama-lengkap-pengguna">Nama Lengkap</label>
        <div class="col-sm-9">
        <input type="text" name="nama_lengkap" class="form-control" id="input-nama-lengkap-pengguna" placeholder="Nama Lengkap" value="{{ isset($officer) ? $officer->nama_lengkap : "" }}" />
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-jenis-kelamin-pengguna">Jenis Kelamin</label>
        <div class="col-sm-9">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="radio-laki-laki" value="L" {{ isset($officer) ? $officer->jenis_kelamin == "L" ? "checked" : "" : "" }}>
                <label class="form-check-label" for="radio-laki-laki">
                  Laki-Laki
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" id="radio-perempuan" value="P" {{ isset($officer) ? $officer->jenis_kelamin == "P" ? "checked" : "" : "" }}>
                <label class="form-check-label" for="radio-perempuan">
                  Perempuan
                </label>
              </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-no-telepon-pengguna">No. Telepon</label>
        <div class="col-sm-9">
        <input type="text" name="no_telpon" class="form-control" id="input-no-telepon-pengguna" placeholder="Nomor Telepon" maxlength="14" value="{{ isset($officer) ? $officer->no_telpon : "" }}" />
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-alamat-pengguna">Alamat</label>
        <div class="col-sm-9">
            <textarea name="alamat" id="input-alamat-penguna" rows="3" class="form-control" placeholder="Alamat Lengkap">{{ isset($officer) ? $officer->alamat : "" }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="float-end">
                <button type="button" data-bs-dismiss="modal" class="btn btn-light">Keluar</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
