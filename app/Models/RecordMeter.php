<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordMeter extends Model
{
    use HasFactory;
    protected $table = "oip_catat_meter";
    protected $fillable = [
        "no_pelanggan",
        "tahun",
        "bulan",
        "angka_meter",
        "volume",
        "kode_area",
    ];
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->hasOne(\App\Models\Customer::class, 'no_pelanggan', 'no_pelanggan');
    }

    public function pembayaran()
    {
        return $this->hasOne(\App\Models\Payment::class, 'catat_meter_id', 'id');
    }

    public function biaya_admin()
    {
        return $this->hasOne(\App\Models\AdminFeePartner::class, 'kode_area', 'kode_area');
    }
}
