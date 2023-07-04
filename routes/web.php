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

    Route::get('/libraries', [Controllers\LibraryController::class, 'index'])->name('libraries.index');
    Route::get('/libraries/{library}', [Controllers\LibraryController::class, 'show'])->name('libraries.show');
    Route::post('/libraries/{library}/follow', [Controllers\LibraryController::class, 'follow'])->name('libraries.follow');
    Route::post('/libraries/{library}/unfollow', [Controllers\LibraryController::class, 'unfollow'])->name('libraries.unfollow');


    Route::name('profile.')->group(function () {
        Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('update');
        Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('me')->name('myaccount.')->group(function () {
        Route::resource('albums', Controllers\MyAccount\AlbumController::class)->except('show');

        Route::name('library.')->group(function () {
            Route::get('/library/create', [Controllers\MyAccount\LibraryController::class, 'create'])->name('create');
            Route::post('/library/create', [Controllers\MyAccount\LibraryController::class, 'store'])->name('store');
            Route::get('/library', [Controllers\MyAccount\LibraryController::class, 'edit'])->name('edit');
            Route::put('/library', [Controllers\MyAccount\LibraryController::class, 'update'])->name('update');
            Route::delete('/library', [Controllers\MyAccount\LibraryController::class, 'destroy'])->name('destroy');
        });
    });

    Route::get('/spotify/redirect', [Controllers\SocialiteController::class, 'redirect'])->name('socialite.spotify.redirect');
    Route::get('/spotify/callback', [Controllers\SocialiteController::class, 'callback'])->name('socialite.spotify.callback');

    Route::prefix('spotify')->name('spotify.')->group(function () {
        Route::post('/search', [Controllers\MyAccount\SpotifyController::class, 'search'])->name('search');
        Route::post('/{id}', [Controllers\MyAccount\SpotifyController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
