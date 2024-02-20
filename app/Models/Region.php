<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = "oip_regions";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'pid'];

    public function parent()
    {
        return $this->belongsTo(Region::class, 'pid', 'id')->with('parent');
    }
}
