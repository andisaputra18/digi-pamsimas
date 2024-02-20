<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function child($id)
    {
        $regions = Region::where("pid", $id)->orderBy('name', 'asc')->get();

        return response()->json(["message" => "Data berhasil dimuat", "data" => $regions]);
    }
}
