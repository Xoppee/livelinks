<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamerController;
use App\Http\Controllers\UserController;

Route::get('/auth', [UserController::class, 'index'])->name('login');
Route::get('/home', [StreamerController::class, 'index'])->name('home');
// Rota dinâmica que aceita o username do streamer
Route::get('/dashboard/{username}', [StreamerController::class, 'index'])->name('dashboard')->middleware('auth');
