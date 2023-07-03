<?php

use App\Http\Controllers;
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

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Controllers\DashboardController::class)->name('dashboard');

    Route::name('profile.')->group(function () {
        Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('update');
        Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::name('library.')->group(function () {
        Route::get('/library/create', [Controllers\LibraryController::class, 'create'])->name('create');
        Route::post('/library/create', [Controllers\LibraryController::class, 'store'])->name('store');
        Route::get('/library', [Controllers\LibraryController::class, 'edit'])->name('edit');
        Route::put('/library', [Controllers\LibraryController::class, 'update'])->name('update');
        Route::delete('/library', [Controllers\LibraryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('me')->name('myaccount.')->group(function () {
        Route::resource('albums', Controllers\MyAccount\AlbumController::class)->except('show');
    });
});

require __DIR__.'/auth.php';
