<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\FeedController::class, 'create'])->name('home');
Route::post('/feeds', [\App\Http\Controllers\FeedController::class, 'store'])->name('feeds.store');
Route::get('/feeds/{token}', [\App\Http\Controllers\FeedController::class, 'show'])->name('feeds.show');
Route::get('/sharedcal/{token}', [\App\Http\Controllers\SharedCalendarController::class, 'show'])->name('shared.calendar');
Route::get('/download/{token}', [\App\Http\Controllers\SharedCalendarController::class, 'download'])->name('download.calendar');
Route::get('/help', function () {
    return view('help');
})->name('help');

Route::middleware(['auth'])->group(function () {
    Route::post('calendar-sources/validate', [\App\Http\Controllers\CalendarSourceController::class, 'validateUrl'])->name('calendar-sources.validate');
    Route::resource('calendar-sources', \App\Http\Controllers\CalendarSourceController::class);
    Route::resource('groups', \App\Http\Controllers\GroupController::class);
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
