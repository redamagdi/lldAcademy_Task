<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SenjabiController;

// API EXAM 
use App\Http\Controllers\API\ExamsController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/newSenjabi', [SenjabiController::class, 'newuser'])->name('newuser');

Route::get('/logs', [SenjabiController::class, 'logs'])->name('logs');

Route::post('exam', [ExamsController::class, 'index']);