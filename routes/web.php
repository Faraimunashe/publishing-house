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

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\publisher\DashboardController@index')->name('admin-dashboard');

    Route::get('/admin/categories', 'App\Http\Controllers\publisher\CategoryController@index')->name('admin-categories');
    Route::post('/admin/add-category', 'App\Http\Controllers\publisher\CategoryController@add')->name('admin-add-category');
    Route::post('/admin/edit-category', 'App\Http\Controllers\publisher\CategoryController@edit')->name('admin-edit-category');

    Route::get('/admin/books', 'App\Http\Controllers\publisher\BookController@index')->name('admin-books');
    Route::post('/admin/edit-book', 'App\Http\Controllers\publisher\BookController@change')->name('admin-edit-book');
    Route::get('/admin/download/{book_id}', 'App\Http\Controllers\publisher\BookController@download')->name('admin-download-book');

    Route::get('/admin/authors', 'App\Http\Controllers\publisher\AuthorController@index')->name('admin-authors');
    Route::post('/admin/edit-author', 'App\Http\Controllers\publisher\AuthorController@change')->name('admin-edit-author');

    Route::get('/admin/sales', 'App\Http\Controllers\publisher\SaleController@index')->name('admin-sales');
    Route::post('/admin/download-sales', 'App\Http\Controllers\publisher\SaleController@download')->name('admin-download-sales');

});


Route::group(['middleware' => ['auth', 'role:author']], function () {
    Route::get('/home', 'App\Http\Controllers\author\HomeController@index')->name('author-home');

    Route::get('/books', 'App\Http\Controllers\author\BooksController@index')->name('author-books');
    Route::get('/book/{id}', 'App\Http\Controllers\author\BooksController@one')->name('author-one-book');
    Route::get('/read/{id}', 'App\Http\Controllers\author\BooksController@read')->name('author-read-book');

    Route::post('/download-book', 'App\Http\Controllers\author\BooksController@download')->name('author-download-book');

    Route::post('/book', 'App\Http\Controllers\author\BooksController@add')->name('author-add-book');
    Route::post('/edit/book', 'App\Http\Controllers\author\BooksController@edit')->name('author-edit-book');

    Route::post('/comment', 'App\Http\Controllers\author\BooksController@comment')->name('author-comment');
    Route::post('/like', 'App\Http\Controllers\author\BooksController@like')->name('author-like');

    Route::get('/sales', 'App\Http\Controllers\author\SalesController@index')->name('author-sales');
    Route::get('/apply-authorship', 'App\Http\Controllers\author\BooksController@apply')->name('author-apply');
});


require __DIR__.'/auth.php';
