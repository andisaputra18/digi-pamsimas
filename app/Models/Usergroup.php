<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usergroup extends Model
{
    use HasFactory;
    protected $table = "oip_user_group";
    public $timestamps = false;
}