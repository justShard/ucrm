<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Підключаємо різні версії API
require __DIR__ . '/api/v1.php';
require __DIR__ . '/api/v2.php';
require __DIR__ . '/api/v3.php';

// Маршрут для отримання даних користувача
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Група маршрутів для аутентифікації з правильним простором імен
Route::prefix('auth')->namespace('App\Http\Controllers\Api\Auth')->group(function () {
    Route::post('/login', 'LoginController');
    Route::post('/logout', 'LogoutController');
    Route::post('/register', 'RegisterController');
});
