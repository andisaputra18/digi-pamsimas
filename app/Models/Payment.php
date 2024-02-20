<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = "oip_pembayaran";
    protected $fillable = [
        "no_transaksi",
        "catat_meter_id",
        "tgl_pembayaran",
        "total_tagihan",
        "uang_dibayarkan",
        "kode_area"
    ];
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->hasOne(\App\Models\Customer::class, 'id', 'pelanggan_id');
    }

    public function catat_meter(){
        return $this->hasOne(\App\Models\RecordMeter::class, 'id', 'catat_meter_id');
    }
}
