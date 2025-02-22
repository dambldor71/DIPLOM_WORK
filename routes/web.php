<?php

use App\Http\Controllers\ChosenTenderController;
use App\Http\Controllers\FavouriteTenderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\WelcomeController;
use App\Models\Category;
use App\Services\Search\TenderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [WelcomeController::class, 'indexWelcome']
)->name('welcome');

Route::get('/mainpage', function (TenderService $service) {
    $categories = Category::query()->get()->toArray();
    $filters = $service->selectFilter()->get()->toArray();
    return view('main.mainpage', compact('categories', 'filters'));
})->middleware(['auth', 'verified'])->name('mainpage');

Route::prefix('/catalog')->controller(TenderController::class)->group(function () {
    Route::get('/catalog', [TenderController::class, 'index'])->name('search');
    Route::get('/catalog/{id}', [TenderController::class, 'show'])->name('tender');
});


Route::post('/set-priority', [ChosenTenderController::class, 'addFavouriteTender']);

Route::get('/favourite-catalog', [FavouriteTenderController::class, 'index'])->name('favourite');
Route::get('/favourite-catalog/{id}', [FavouriteTenderController::class, 'show'])->name('favourite-tender');

Route::get('/test', function (TenderService $service) {
    $categories = Category::query()->get()->toArray();
    $filters = $service->selectFilter()->get()->toArray();
    return view('profile.editinfo', compact('categories', 'filters'));
})->name('test');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('mainpage');
})->name('logout');

require __DIR__.'/auth.php';
