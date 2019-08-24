<?php

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
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/category', 'CategoryController@index')->name('category');
Route::get('/category/json','CategoryController@json')->name('category.json');
Route::get('/product', 'ProductController@index')->name('product');
Route::get('/product/json','ProductController@json')->name('product.json');
Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/json','UserController@json')->name('user.json');
Route::get('/mail', 'MailController@index')->name('mail');
