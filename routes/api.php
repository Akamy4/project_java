<?php

use App\Http\Controllers\PublishingController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookGenreController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    //!!!=================================== All url ===================================!!!//
    //***================================= Publishing ===================================***/
    Route::get('/publishing_all', [PublishingController::class, 'all']);
    Route::post('/publishing_add', [PublishingController::class, 'add']);
    Route::put('/publishing_update', [PublishingController::class, 'update']);
    Route::get('/publishing_by_id/{id}', [PublishingController::class, 'by_id']);
    Route::get('/publishing_by_name/{name}', [PublishingController::class, 'by_name']);
    Route::delete('/publishing_delete/{id}', [PublishingController::class, 'delete']);

    //***==================================== Author ===================================***/
    Route::get('/author_all', [AuthorController::class, 'all']);
    Route::post('/author_add', [AuthorController::class, 'add']);
    Route::put('/author_update', [AuthorController::class, 'update']);
    Route::get('/author_by_id/{id}', [AuthorController::class, 'by_id']);
    Route::get('/author_by_name/{name}', [AuthorController::class, 'by_name']);
    Route::delete('/author_delete/{id}', [AuthorController::class, 'delete']);

    //***==================================== Book ===================================***/
    Route::get('/book_all', [BookController::class, 'all']);
    Route::post('/book_add', [BookController::class, 'add']);
    Route::put('/book_update', [BookController::class, 'update']);
    Route::get('/book_by_id/{id}', [BookController::class, 'by_id']);
    Route::get('/book_by_name/{name}', [BookController::class, 'by_name']);
    Route::delete('/book_delete/{id}', [BookController::class, 'delete']);

    //***==================================== Genre ===================================***/
    Route::get('/genre_all', [GenreController::class, 'all']);
    Route::post('/genre_add', [GenreController::class, 'add']);
    Route::put('/genre_update', [GenreController::class, 'update']);
    Route::get('/genre_by_id/{id}', [GenreController::class, 'by_id']);
    Route::get('/genre_by_name/{name}', [GenreController::class, 'by_name']);
    Route::delete('/genre_delete/{id}', [GenreController::class, 'delete']);

    //***==================================== BookGenre ===================================***/
    Route::get('/book_genre_all', [BookGenreController::class, 'all']);
    Route::post('/book_genre_add', [BookGenreController::class, 'add']);
    Route::put('/book_genre_update', [BookGenreController::class, 'update']);
    Route::delete('/book_genre_delete/{id}', [BookGenreController::class, 'delete']);
});

Route::post('/authorization', [UserController::class, 'authorization']);