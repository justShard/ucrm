<?php

use \App\Http\Controllers\Api\Auth\LoginController;
use \App\Http\Controllers\Api\Auth\LogoutController;
use \App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;

require __DIR__.'/api/v1.php';
require __DIR__.'/api/v2.php';


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function(){
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class);
    Route::post('/register', RegisterController::class);
});