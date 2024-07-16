<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\PulperController;
use App\Http\Controllers\HullerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::prefix("farmer")->middleware(['auth', 'verified'])->group(function () {
    Route::get("", [FarmerController::class, 'index'])->name('farmer.index');
});

Route::prefix("pulper")->middleware(['auth', 'verified'])->group(function () {
    Route::get("", [PulperController::class, 'index'])->name('pulper.index');
});

Route::prefix("huller")->middleware(['auth', 'verified'])->group(function () {
    Route::get("", [HullerController::class, 'index'])->name('huller.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
