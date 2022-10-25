<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:author']], function () {
    Route::get('/home', 'App\Http\Controllers\author\HomeController@index')->name('author-home');

    Route::get('/books', 'App\Http\Controllers\author\BooksController@index')->name('author-books');
    Route::get('/book/{id}', 'App\Http\Controllers\author\BooksController@one')->name('author-one-book');
    Route::get('/read/{id}', 'App\Http\Controllers\author\BooksController@read')->name('author-read-book');
    Route::post('/book', 'App\Http\Controllers\author\BooksController@add')->name('author-add-book');
    Route::post('/edit/book', 'App\Http\Controllers\author\BooksController@edit')->name('author-edit-book');

    Route::post('/comment', 'App\Http\Controllers\author\BooksController@comment')->name('author-comment');
    Route::post('/like', 'App\Http\Controllers\author\BooksController@like')->name('author-like');

    Route::get('/sales', 'App\Http\Controllers\author\SalesController@index')->name('author-sales');
});


require __DIR__.'/auth.php';
