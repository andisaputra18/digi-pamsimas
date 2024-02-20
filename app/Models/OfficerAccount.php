<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class OfficerAccount extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $table = "oip_akun_petugas";
    protected $fillable = [
        "petugas_id",
        "username",
        "password"
    ];
    public $timestamps = false;
}
