<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFee extends Model
{
    use HasFactory;
    protected $table = "oip_biaya_admin";
    protected $fillable = [
        "biaya"
    ];
    public $timestamps = false;

    public function mitra()
    {
        return $this->hasMany(\App\Models\AdminFeePartner::class, 'biaya_admin_id', 'id');
    }
}
