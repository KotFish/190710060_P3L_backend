<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengemudiController;
use App\Http\Controllers\PromoController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'ability:Administrator'])->group(function () {
    Route::apiResource('pegawai', PegawaiController::class);
    Route::apiResource('pengemudi', PengemudiController::class);
});

Route::middleware(['auth:sanctum', 'ability:Manager'])->group(function () {
    Route::apiResource('promo', PromoController::class);
});

Route::middleware(['auth:sanctum', 'ability:Customer Service'])->group(function () {
    Route::apiResource('pelanggan', PelangganController::class);
});

