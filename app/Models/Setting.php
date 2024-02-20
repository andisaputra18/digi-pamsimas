<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = "oip_setting_biaya";
    protected $fillable = [
        "kategori_bangunan_id",
        "biaya_abodemen",
        "pengaturan_biaya",
        "biaya",
        "kode_area",
    ];
    public $timestamps = false;

    public function category()
    {
        return $this->hasOne(\App\Models\Category::class, 'id', 'kategori_bangunan_id');
    }
}
