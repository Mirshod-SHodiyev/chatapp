<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/chat',[ChatController::class, 'index'])->name('chat.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/api/users', [UserController::class, 'index']);
    Route::get('/api/messages/{id}', [ChatController::class, 'getMessages']);
    Route::post('/api/messages', [ChatController::class, 'storeMessages']);
});

require __DIR__.'/auth.php';
