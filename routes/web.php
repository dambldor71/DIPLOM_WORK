<?php

use App\Http\Controllers\AddDeleteSettingsController;
use App\Http\Controllers\ChosenTenderController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FavouriteTenderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UpdateTenderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\Category;
use App\Services\Search\TenderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/account-settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account-settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account-settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [WelcomeController::class, 'indexWelcome']
)->name('welcome');

Route::get('/mainpage', function (TenderService $service) {
    $categories = Category::query()->get()->toArray();
    $filters = $service->selectFilter()->get()->toArray();
    return view('main.mainpage', compact('categories', 'filters'));
})->middleware(['auth', 'verified'])->name('mainpage');

Route::prefix('/catalog')->controller(TenderController::class)->group(function () {
    Route::get('/', [TenderController::class, 'index'])->name('search');
    Route::get('/{id}', [TenderController::class, 'show'])->name('tender');
});

Route::post('/favourite-add', [ChosenTenderController::class, 'addFavouriteTender']);
Route::post('/favourite-delete', [ChosenTenderController::class, 'removeFavouriteTender']);
Route::post('/favourite-stage', [ChosenTenderController::class, 'addStageTender']);

Route::get('/favourite-catalog', [FavouriteTenderController::class, 'index'])->name('favourite');
Route::get('/favourite-catalog/{id}', [FavouriteTenderController::class, 'show'])->name('favourite-tender');

Route::get('/profile/{id}', [UserController::class, 'index'])->name('test');
Route::post('/profile/update', [UserController::class, 'update'])->name('update');

Route::post('/priority-add', [AddDeleteSettingsController::class, 'addPriority'])->name('priority-add');
Route::post('/priority-delete', [AddDeleteSettingsController::class, 'deletePriority'])->name('priority-delete');

Route::post('/stage-add', [AddDeleteSettingsController::class, 'addStage'])->name('stage-add');
Route::post('/stage-delete', [AddDeleteSettingsController::class, 'deleteStage'])->name('stage-delete');

Route::get('/favourite/export', [ExcelController::class, 'export'])->name('export');

Route::get('/support', [SupportController::class, 'index'])->name('support');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('mainpage');
})->name('logout');

Route::post('/testUpdate', [UpdateTenderController::class, 'updateTender'])->name('testUpdate');

require __DIR__.'/auth.php';
