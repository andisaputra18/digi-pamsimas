<?php

use App\Http\Controllers\AdminFeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecordMeterController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'authenticate'])->name('login.authenticate');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    // Record Meter
    Route::resource('catat_meter', RecordMeterController::class);
    Route::get('catat_meter/cek/{no}', [RecordMeterController::class, 'check_record_meter']);
    Route::get('catat_meter/bulan_sebelumnya/{no}', [RecordMeterController::class, 'get_prev_month']);
    // Payment
    Route::resource('pembayaran', PaymentController::class);
    Route::get('pembayaran/cek_pembayaran/{no}', [PaymentController::class, 'check_has_payment']);
    Route::get('pembayaran/bulan_sebelumnya/{no}', [PaymentController::class, 'get_prev_month']);
    Route::get('pembayaran/modal/berhasil', [PaymentController::class, 'modal']);
    // Customer
    Route::resource('pelanggan', CustomerController::class);
    Route::get('pelanggan/profil/{no}', [CustomerController::class, 'getCustomerById'])->name('pelanggan.profil');
    Route::get('pelanggan/delete/{id}', [CustomerController::class, 'delete']);
    // Setting
    Route::resource('rumus', SettingController::class);
    Route::get('rumus/biaya/{no}', [SettingController::class, 'biaya']);
    Route::get('rumus/status/{id}', [SettingController::class, 'status']);
    Route::get('rumus/delete/{id}', [SettingController::class, 'delete']);
    Route::get('rumus/cek/{id}', [SettingController::class, 'check']);
    // Partner
    Route::resource('mitra', PartnerController::class);
    Route::get('mitra/delete/{id}', [PartnerController::class, 'delete']);
    // Officer Account
    Route::resource('petugas', OfficerController::class);
    Route::get('petugas/add/{id}', [OfficerController::class, 'add']);
    Route::get('petugas/delete/{id}', [OfficerController::class, 'delete']);
    // User
    Route::resource('pengguna', UserController::class);
    // Admin Fee
    Route::resource('biaya_admin', AdminFeeController::class);
    Route::get('biaya_admin/mitra/tambah/{id}', [AdminFeeController::class, 'add_mitra']);
    Route::post('biaya_admin/mitra', [AdminFeeController::class, 'insert_mitra']);
    Route::get('biaya_admin/hapus_mitra/{kode_area}', [AdminFeeController::class, 'delete_mitra']);

    Route::get('region/child/{id}', [RegionController::class, 'child']);
    Route::post('logout', [AuthController::class, 'logout']);
});
