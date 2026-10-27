<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index'])->name('idea.index');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.store');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('idea.show');
    Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])->name('idea.update');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('idea.destroy');
    Route::delete('/ideas/{idea}/image', [IdeaImageController::class, 'destroy'])->name('idea.image.destroy');

    Route::patch('/steps/{step}', [StepController::class, 'update'])->name('step.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [SessionController::class, 'destroy']);
});