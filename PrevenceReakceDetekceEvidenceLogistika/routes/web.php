<?php

/*
i love lalavel
*/

use App\Http\Controllers\IncommingController;
use App\Http\Controllers\OutcommingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Middleware\Administration;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.view');
})->middleware(['auth'])->name('dashboard');

Route::get('/history', function () {
    return view('history.view');
})->middleware(['auth'])->name('history');

Route::middleware(['auth', Administration::class])->group(function () {
    Route::get('/incommings', [IncommingController::class, 'index'])->name('incomming.list');
    Route::get('/outcommings', [OutcommingController::class, 'index'])->name('outcomming.list');
    Route::get('/sales', [SaleController::class, 'index'])->name('sale.list');
});

Route::middleware(['auth', Administration::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
