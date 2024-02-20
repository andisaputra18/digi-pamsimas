<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RecordMeterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'authenticate']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('pelanggan/{search}', [CustomerController::class, 'search']);
    Route::get('pelanggan/daftar/{area}', [CustomerController::class, 'list']);

    Route::get('catat_meter/bulan_lalu/{customer_number}', [RecordMeterController::class, 'prev_month']);
    Route::post('catat_meter/bulan_ini/{customer_number}', [RecordMeterController::class, 'this_month']);
    Route::get('catat_meter/detail/{id}', [RecordMeterController::class, 'detail']);
    Route::get('catat_meter/loket/{area}', [RecordMeterController::class, 'loket']);

    Route::get('pembayaran/{area}', [PaymentController::class, 'history']);
    Route::post('pembayaran/catat_meter/{no}', [PaymentController::class, 'record_meter']);

    Route::get('logout/{id}', [AuthController::class, 'logout']);
});
