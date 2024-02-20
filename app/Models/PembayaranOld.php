<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranOld extends Model
{
    use HasFactory;
    protected $table = "oip_pembayaran";
    protected $fillable = [
        "no_transaksi",
        "pelanggan_id",
        "setting_biaya_id",
        "tahun",
        "bulan",
        "posisi_meter",
        "volume",
        "total_tagihan",
        "uang_dibayarkan",
        "kode_area"
    ];
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->hasOne(\App\Models\Customer::class, 'id', 'pelanggan_id');
    }
}
