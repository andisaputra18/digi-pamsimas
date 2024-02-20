@extends('layouts.app')
@section('title', 'digiPamsimas - Setting Biaya')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Setting Pembayaran / Form /</span> {{ isset($setting) ? "Ubah" : "Tambah" }} Settingan</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Form {{ isset($setting) ? "Ubah" : "Tambah" }} Settingan</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('rumus.store') }}">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="select-kategori-bangunan">Kategori Bangunan</label>
                    <div class="col-sm-4">
                        <select name="kategori_bangunan_id" id="select-kategori-bangunan" class="form-select">
                            <option value="">Pilih Kategori Bangunan</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="input-abodemen">Biaya Abodemen</label>
                    <div class="col-sm-4">
                        <input type="text" name="biaya_abodemen" class="form-control input-number" id="input-abodemen" placeholder="Biaya Abodemen" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="input-abodemen">Pengaturan Biaya</label>
                    <div class="col-sm-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pengaturan_biaya" id="radio-pengaturan-satu" value="1" onclick="setCost(this)">
                            <label class="form-check-label" for="radio-pengaturan-satu">
                                Sekali Biaya
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="pengaturan_biaya" id="radio-pengaturan-dua" value="2" onclick="setCost(this)">
                            <label class="form-check-label" for="radio-pengaturan-dua">
                              Rentang Biaya
                            </label>
                          </div>
                    </div>
                </div>
                <div id="rentan-biaya" class="d-none">
                    <div class="row mb-3 input-rentan-biaya">
                        <label class="col-sm-2 col-form-label">Angka Meter Awal</label>
                        <div class="col-sm-2">
                            <input type="number" name="angka_meter_awal_rentan[]" class="form-control input" placeholder="Dalam m3"/>
                        </div>
                        <label class="col-sm-2 col-form-label">Angka Meter Akhir</label>
                        <div class="col-sm-2">
                            <input type="number" name="angka_meter_akhir_rentan[]" class="form-control input" placeholder="Dalam m3"/>
                        </div>
                        <label class="col-sm-1 col-form-label">Tarif</label>
                        <div class="col-sm-2">
                            <input type="text" name="tarif_rentan[]" class="form-control input-number" placeholder="Tarif" />
                        </div>
                        <button type="button" class="btn btn-sm btn-danger remove d-none" onclick="deleteRow(this)" style="width: 40px;">X</button>
                    </div>
                </div>
                <div class="row justify-content-end d-none" id="button-tambah-rentan-biaya">
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-info" onclick="createNewRow()">Tambah</button>
                    </div>
                </div>
                <div id="sekali-biaya" class="d-none">
                   <input type="hidden" name="angka_meter_awal_sekali[]" class="form-control" placeholder="Dalam m3"/>
                   <input type="hidden" name="angka_meter_akhir_sekali[]" class="form-control" placeholder="Dalam m3" value="999"/>
                    <div class="row mb-3 input-sekali-biaya">
                        <label class="col-sm-2 col-form-label">Angka Meter</label>
                        <div class="col-sm-2">
                            <span>0 s.d Seterusnya</span>
                        </div>
                        <label class="col-lg-1 col-form-label">Tarif</label>
                        <div class="col-lg-2">
                            <input type="text" name="tarif_sekali[]" class="form-control input-number" placeholder="Tarif" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<script>
    function setCost(e){
        let value = e.value;
        let input1 = document.getElementById('sekali-biaya');
        let input2 = document.getElementById('rentan-biaya');
        let button = document.getElementById('button-tambah-rentan-biaya');

        if (value == 1) {
            input1.classList.remove('d-none');
            input2.classList.add('d-none');
            button.classList.add('d-none');
        } else if(value == 2){
            input1.classList.add('d-none');
            input2.classList.remove('d-none');
            button.classList.remove('d-none');
        }
    }

    let nilai = document.getElementById('rentan-biaya');

    function createNewRow() {
        let child = nilai.querySelector('.input-rentan-biaya')
        let cloneChild = child.cloneNode(true)
        console.log(cloneChild);

        cloneChild.querySelector('input').value = "";
        nilai.appendChild(cloneChild)
        checkRow()
    }

    function deleteRow(e) {
        if (nilai.querySelectorAll('.input-rentan-biaya').length > 1)
            e.parentNode.remove()
        checkRow()
    }

    function checkRow() {
        let nilaiCount = nilai.querySelectorAll('.input-rentan-biaya').length
        let removeButtons = nilai.querySelectorAll('.remove')

        if (nilaiCount == 1) {
            for (button of removeButtons) {
                button.classList.add('d-none')
            }
        } else {
            for (button of removeButtons) {
                if (button.classList.contains('d-none'))
                    button.classList.remove('d-none')
            }
        }
    }

</script>
@endsection
