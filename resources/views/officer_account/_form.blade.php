<form method="POST" action="{{ route('akun_petugas.store') }}">
    @csrf
    <input type="hidden" name="mitra_id" value="{{ $partner->id }}">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="input-username-pengguna">Username</label>
        <div class="col-sm-10">
            <input type="text" name="username" class="form-control" id="input-username-pengguna" placeholder="Username" />
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="input-password-pengguna">Password</label>
        <div class="col-sm-10">
        <input type="password" name="password" class="form-control" id="input-password-pengguna" placeholder="Password" />
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
