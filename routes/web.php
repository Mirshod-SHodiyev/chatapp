<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/api/users', [UserController::class, 'index']);
Route::get('/api/messages/{id}', [ChatController::class, 'getMessages']);
Route::post('/api/messages', [ChatController::class, 'storeMessages']);

Route::put('/api/users/{id}', [ProfileController::class, 'update']);
Route::delete('/api/users/{id}', [ProfileController::class, 'destroy']);


Route::middleware('auth')->group(function () {
    Route::get('/chat',[ChatController::class, 'index'])->name('home');
    Route::get('/my-profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');



});

require __DIR__.'/auth.php';
