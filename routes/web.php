<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WinkelwagenController;
use App\Http\Controllers\BestellingController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('/', [WinkelwagenController::class, 'index'])->name('menu');
Route::post('/menu', [WinkelwagenController::class, 'store'])->name('menu.store');
Route::delete('/menu/{winkelwagen}', [WinkelwagenController::class, 'destroy'])->name('menu.destroy');
Route::post('/bestelling', [BestellingController::class, 'create'])->name('bestel.create');
Route::any('/bestellingen', [BestellingController::class, 'store'])->name('bestel.store');
Route::any('/winkelwagen', [BestellingController::class, 'destroy'])->name('winkelwagen.destroy');
Route::get('/status/{bestelling}', [BestellingController::class, 'show'])->name('status.show');