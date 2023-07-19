<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuTamuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'homepage')->name('homepage');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginPost');
    Route::post('/buku-tamu/store', [BukuTamuController::class, 'store'])->name('storeBukuTamu');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::resource('buku-tamu', BukuTamuController::class);
});
