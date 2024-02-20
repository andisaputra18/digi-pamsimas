<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $table = "oip_mitra";
    protected $fillable = [
        "nama_pamsimas",
        "kode_area",
        "wilayah",
        "kecamatan",
        "kabupaten",
        "provinsi",
    ];
    public $timestamps = false;

    public function petugas()
    {
        return $this->hasMany(\App\Models\Officer::class, 'mitra_id', 'id');
    }
}
