<?php

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

Route::get('/external-books', 'IcefireController@index');



Route::prefix('v1')->group(function () {
    Route::post('/books', 'BooksController@create');
    Route::get('/books', 'BooksController@index');
    Route::get('/books/{id}', 'BooksController@show');
    Route::patch('/books/{id}', 'BooksController@update');
    Route::delete('/books/{id}', 'BooksController@destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
