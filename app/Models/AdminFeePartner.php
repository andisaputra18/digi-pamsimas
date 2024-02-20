<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFeePartner extends Model
{
    use HasFactory;
    protected $table = "oip_biaya_admin_mitra";
    protected $fillabel = [
        "biaya_admin_id",
        "kode_area"
    ];
    public $timestamps = false;

    public function mitra()
    {
        return $this->hasOne(\App\Models\Partner::class, 'kode_area', 'kode_area');
    }

    public function biaya()
    {
        return $this->hasOne(\App\Models\AdminFee::class, 'id', 'biaya_admin_id');
    }
}
