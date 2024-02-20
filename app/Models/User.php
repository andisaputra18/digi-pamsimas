<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "oip_user";
    protected $fillable = [
        'user_group_id',
        'username',
        'password',
        'kode_area'
    ];
    protected $hidden = ["password"];
    public $timestamps = false;

    public function group()
    {
        return $this->hasOne(\App\Models\Usergroup::class, 'id', 'user_group_id');
    }

    public function mitra()
    {
        return $this->hasOne(\App\Models\Partner::class, 'kode_area', 'kode_area');
    }
}
