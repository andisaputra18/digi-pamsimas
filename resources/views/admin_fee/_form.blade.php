<form method="POST" action="{{ route('biaya_admin.store') }}">
    @csrf
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="input-biaya-admin">Biaya Admin</label>
        <div class="col-sm-9">
        <input type="text" name="biaya" class="form-control" id="input-biaya-admin" placeholder="Biaya Admin" />
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
