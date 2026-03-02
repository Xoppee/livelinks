<?php

use App\Http\Controllers\LinksController;
use App\Http\Controllers\StreamerController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::patch('/links/{id}/watched', [LinksController::class, 'markWatched']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/moderator/accept/{id}', [ModeratorController::class, 'acceptLink']);
    Route::delete('/moderator/decline/{id}', [ModeratorController::class, 'declineLink']);
});
Route::post('/link', [LinksController::class, 'store']);
Route::post('/show/link', [LinksController::class, 'index']);
Route::post('/streamer/addMod', [StreamerController::class, 'addMod']);