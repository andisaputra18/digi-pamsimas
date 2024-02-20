<form method="POST" action="{{ url('biaya_admin/mitra') }}">
    @csrf
    <input type="hidden" name="biaya_admin_id" value="{{ $fee->id }}">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-biaya-admin">Mitra</label>
        <div class="col-sm-9">
            <select name="kode_area" class="form-select">
                <option value="">Pilih Mitra</option>
                @foreach ($partners as $partner)
                    <option value="{{ $partner->kode_area }}">Desa {{ $partner->wilayah }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
