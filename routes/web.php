<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdeaController;

Route::get('/', [IdeaController::class, 'index'])->name('ideas.index');
Route::resource('ideas', IdeaController::class);

// API routes for AJAX
Route::prefix('api/ideas')->group(function () {
    Route::post('bulk-action', [IdeaController::class, 'bulkAction'])->name('ideas.bulk-action');
    Route::patch('{idea}/toggle-favorite', [IdeaController::class, 'toggleFavorite'])->name('ideas.toggle-favorite');
});



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
