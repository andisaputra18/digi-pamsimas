<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "oip_pelanggan";
    protected $fillable = [
        "no_pelanggan",
        "kategori_bangunan_id",
        "nik",
        "nama_lengkap",
        "alamat",
        "kode_area"
    ];
    public $timestamps = false;

    public function kategori()
    {
        return $this->hasOne(\App\Models\Category::class, 'id', 'kategori_bangunan_id');
    }

    public function setting()
    {
        return $this->hasOne(\App\Models\Setting::class, 'kategori_bangunan_id', 'kategori_bangunan_id');
    }
}
