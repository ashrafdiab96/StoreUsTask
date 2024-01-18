<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\WriterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['log.request'])->group(function () {
    /**
     * Writer Routes
     */
    Route::get('/writers', [WriterController::class, 'get']);
    Route::get('/writers/{id}', [WriterController::class, 'getOne']);
    Route::post('/writers', [WriterController::class, 'create']);
    Route::put('/writers/{id}', [WriterController::class, 'update']);
    Route::delete('/writers/{id}', [WriterController::class, 'delete']);

    /**
     * Books Routes
     */
    Route::get('/books', [BooksController::class, 'get']);
    Route::get('/books/{id}', [BooksController::class, 'getOne']);
    Route::post('/books', [BooksController::class, 'create']);
    Route::put('/books/{id}', [BooksController::class, 'update']);
    Route::delete('/books/{id}', [BooksController::class, 'delete']);

    /**
     * Articles Routes
     */
    Route::get('/articles', [ArticlesController::class, 'get']);
    Route::get('/articles/{id}', [ArticlesController::class, 'getOne']);
    Route::post('/articles', [ArticlesController::class, 'create']);
    Route::put('/articles/{id}', [ArticlesController::class, 'update']);
    Route::delete('/articles/{id}', [ArticlesController::class, 'delete']);
});
