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
Route::get('home', 'HomeController@index')->name('home');
Route::get('category', 'CategoryController@index')->name('category');
Route::post('category/store', 'CategoryController@store')->name('category.store');
Route::get('category/edit/{id}', 'CategoryController@edit')->name('category.edit');
Route::get('category/delete/{id}', 'CategoryController@destroy')->name('category.destroy');
Route::get('category/json','CategoryController@json')->name('category.json');
Route::get('product', 'ProductController@index')->name('product');
Route::get('product', 'ProductController@index')->name('product');
Route::post('product/store', 'ProductController@store')->name('product.store');
Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::get('product/delete/{id}', 'ProductController@destroy')->name('product.destroy');
Route::get('product/json','ProductController@json')->name('product.json');
Route::get('user', 'UserController@index')->name('user');
Route::post('user/store', 'UserController@store')->name('user.store');
Route::get('user/edit/{id}', 'UserController@edit')->name('user.edit');
Route::get('user/delete/{id}', 'UserController@destroy')->name('user.destroy');
Route::get('user/json','UserController@json')->name('user.json');
Route::get('mail', 'MailController@index')->name('mail');
