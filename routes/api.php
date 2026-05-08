<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ExternalBookController;
use Illuminate\Support\Facades\Route;

Route::get('/external-books', [ExternalBookController::class, 'index']);

Route::prefix('v1')->group(function () {
    Route::get('/books',           [BookController::class, 'index']);
    Route::post('/books',          [BookController::class, 'store']);
    Route::get('/books/{book}',    [BookController::class, 'show']);
    Route::patch('/books/{book}',  [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);
    Route::post('/books/{book}/delete', [BookController::class, 'destroy']);
});