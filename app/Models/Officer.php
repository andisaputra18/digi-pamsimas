<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;
    protected $table = "oip_petugas";
    protected $fillable = [
        "mitra_id",
        "nik",
        "nama_lengkap",
        "jenis_kelamin",
        "no_telpon",
        "alamat"
    ];
    public $timestamps = false;
}
