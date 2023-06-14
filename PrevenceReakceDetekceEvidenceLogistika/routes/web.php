<?php

/*
i love lalavel
*/

use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutcomingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Middleware\Administration;
use App\Models\Incoming;
use App\Models\Outcoming;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    $actions = ['action.incoming'];
    return view('dashboard.view', [
        'actionIncoming' => Incoming::where('checked', '==', false)->count(),
        'actionOutcoming' => Outcoming::where('checked', '==', false)->count(),
        'actionResponder' => Incoming::where('checked', '==', false)->count(),
    ]);
})->middleware(['auth'])->name('dashboard');

Route::get('/history', function () {
    if (Auth::user()->role == Role::INCOMING)
        return view('incoming.list', ['data' => Incoming::all()]);
    if (Auth::user()->role == Role::OUTCOMING)
        return view('outcoming.list', ['data' => Outcoming::all()]);
    return view('history.view');
})->middleware(['auth'])->name('history');

Route::middleware(['auth'])->group(function () {
    Route::get('/incomings', [IncomingController::class, 'index'])->name('incoming.list');
    Route::get('/incomings/view/{incoming}', [IncomingController::class, 'show'])->name('incoming.view');
    Route::get('/incomings/new', [IncomingController::class, 'create'])->name('incoming.new');
    Route::post('/incomings/new', [IncomingController::class, 'storeByEmployee']);
    Route::post('/incomings/check/{incoming}', [IncomingController::class, 'updateCheck'])->name('incoming.check');
    Route::get('/incomings/checks', function () { return view('incoming.list', ['data' => Incoming::all()->where('checked', false)]); })->name('incoming.checks');

    Route::get('/outcomings', [OutcomingController::class, 'index'])->name('outcoming.list');
    Route::get('/outcomings/view/{outcoming}', [OutcomingController::class, 'show'])->name('outcoming.view');
    Route::get('/outcomings/new', [OutcomingController::class, 'create'])->name('outcoming.new');
    Route::post('/outcomings/new', [OutcomingController::class, 'storeByEmployee']);
    Route::post('/outcomings/check/{outcoming}', [OutcomingController::class, 'updateCheck'])->name('outcoming.check');
    Route::get('/outcomings/checks', function () { return view('outcoming.list', ['data' => Outcoming::all()->where('checked', false)]); })->name('outcoming.checks');

    Route::get('/sales', [SaleController::class, 'index'])->name('sale.list');
    Route::get('/sales/view/{sale}', [SaleController::class, 'show'])->name('sale.view');
    Route::get('/sales/new', [SaleController::class, 'create'])->name('sale.new');
    Route::post('/sales/new', [SaleController::class, 'storeByEmployee']);
});

Route::middleware(['auth', Administration::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/view/{user}', [UserController::class, 'show'])->name('user.view');
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
