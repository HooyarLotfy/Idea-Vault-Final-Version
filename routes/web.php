<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdeaController;

// All routes use the web middleware group by default in Laravel
Route::get('/', [IdeaController::class, 'index'])->name('ideas.index');
Route::resource('ideas', IdeaController::class);

// API routes for AJAX with CSRF protection
Route::prefix('api/ideas')->middleware(['web'])->group(function () {
    Route::get('filter', [IdeaController::class, 'filter'])->name('ideas.filter'); // Filter endpoint for AJAX
    Route::patch('{idea}/toggle-favorite', [IdeaController::class, 'toggleFavorite'])->name('ideas.toggle-favorite');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Include auth routes
require __DIR__.'/auth.php';
