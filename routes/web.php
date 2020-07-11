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

Auth::routes();

# Root page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/page', function(){ abort(404); });
Route::post('/page', 'PageController@get')->name('page.get');
Route::get('/page/{ref_page}', 'PageController@index')->name('page.index');

# Api rest for axios
Route::get('/comments/{url}', 'CommentController@index')->name('comments.index');
Route::post('/comments', 'CommentController@store')->name('comments.store');
Route::put('/comments/{comment}', 'CommentController@update')->name('comments.update');
Route::delete('/comments/{comment}', 'CommentController@destroy')->name('comments.destroy');

Route::get('/home', 'HomeController@index')->name('home');
