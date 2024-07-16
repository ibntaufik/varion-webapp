<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\PulperController;
use App\Http\Controllers\HullerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix("location")->group(function () {
    Route::get("farmer", [FarmerController::class, 'location'])->name('farmer.location');
    Route::get("pulper", [PulperController::class, 'location'])->name('pulper.location');
    Route::get("huller", [HullerController::class, 'location'])->name('huller.location');
});

Route::prefix("farmer")->group(function () {
    Route::get("", [FarmerController::class, 'list'])->name('farmer.list');
    Route::get("find", [FarmerController::class, 'find'])->name('farmer.find');
    Route::get("transaction", [FarmerController::class, 'transaction'])->name('farmer.transaction');
});

Route::prefix("pulper")->group(function () {
    Route::get("", [PulperController::class, 'list'])->name('pulper.list');
    Route::get("transaction", [PulperController::class, 'transaction'])->name('pulper.transaction');
});
    
Route::prefix("huller")->group(function () {
    Route::get("find", [HullerController::class, 'find'])->name('huller.find');
    Route::get("transaction", [HullerController::class, 'transaction'])->name('huller.transaction');
});