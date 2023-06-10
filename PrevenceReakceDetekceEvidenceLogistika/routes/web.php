<?php

/*
i love lalavel
*/

use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutcomingController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/incomings', [IncomingController::class, 'index'])->name('incoming.list');
    Route::get('/incomings/{incoming}', [IncomingController::class, 'show'])->name('incoming.view');

    Route::get('/outcomings', [OutcomingController::class, 'index'])->name('outcoming.list');
    Route::get('/outcomings/{outcoming}', [OutcomingController::class, 'show'])->name('outcoming.view');

    Route::get('/sales', [SaleController::class, 'index'])->name('sale.list');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sale.view');
});

Route::middleware(['auth', Administration::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('user.view');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/users/edit/{user}', [UserController::class, 'update']);
    Route::delete('/users/edit/{user}', [UserController::class, 'destroy'])->name('user.delete');

    Route::get('/incomings/edit/{incoming}', [IncomingController::class, 'edit'])->name('incoming.edit');
    Route::patch('/incomings/edit/{incoming}', [IncomingController::class, 'update']);
    Route::delete('/incomings/edit/{incoming}', [IncomingController::class, 'destroy'])->name('incoming.delete');

    Route::get('/outcomings/edit/{outcoming}', [OutcomingController::class, 'edit'])->name('outcoming.edit');
    Route::patch('/outcomings/edit/{outcoming}', [OutcomingController::class, 'update']);
    Route::delete('/outcomings/edit/{outcoming}', [OutcomingController::class, 'destroy'])->name('outcoming.delete');

    Route::get('/sales/edit/{sale}', [SaleController::class, 'edit'])->name('sale.edit');
    Route::patch('/sales/edit/{sale}', [SaleController::class, 'update']);
    Route::delete('/sales/edit/{sale}', [SaleController::class, 'destroy'])->name('sale.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
