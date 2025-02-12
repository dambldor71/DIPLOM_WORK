<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TenderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/mainpage', function () {
    return view('main.mainpage');
})->middleware(['auth', 'verified'])->name('mainpage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('mainpage');
})->name('logout');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/{id}', [TenderController::class, 'index'])->name('tender');
require __DIR__.'/auth.php';
