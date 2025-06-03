<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v3')->group(function (){

    Route::get('/files', [\App\Http\Controllers\Api\V3\FilesController::class, 'index']);
    Route::post('/files', [\App\Http\Controllers\Api\V3\FilesController::class, 'store']);
    Route::get('/files/{id}', [\App\Http\Controllers\Api\V3\FilesController::class, 'show']);
    Route::put('/files/{id}', [\App\Http\Controllers\Api\V3\FilesController::class, 'update']);
    Route::delete('/files/{id}', [\App\Http\Controllers\Api\V3\FilesController::class, 'destroy']);
    Route::patch('/files/{id}', [\App\Http\Controllers\Api\V3\FilesController::class, 'complete']);
});

?>
