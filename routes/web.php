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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', Controllers\DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/library/create', [Controllers\Admin\LibraryController::class, 'create'])->name('library.create');
    Route::post('/library/create', [Controllers\Admin\LibraryController::class, 'store'])->name('library.store');
    Route::get('/library', [Controllers\Admin\LibraryController::class, 'edit'])->name('library.edit');
    Route::put('/library', [Controllers\Admin\LibraryController::class, 'update'])->name('library.update');
    Route::delete('/library', [Controllers\Admin\LibraryController::class, 'destroy'])->name('library.destroy');
});

require __DIR__.'/auth.php';
