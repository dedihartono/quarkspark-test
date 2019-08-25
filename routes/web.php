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
Route::get('category', 'CategoryController@index')->name('category')->middleware('users');
Route::post('category/store', 'CategoryController@store')->name('category.store')->middleware('users');
Route::get('category/edit/{id}', 'CategoryController@edit')->name('category.edit')->middleware('users');
Route::get('category/delete/{id}', 'CategoryController@destroy')->name('category.destroy')->middleware('users');
Route::get('category/json','CategoryController@json')->name('category.json')->middleware('users');
Route::get('product', 'ProductController@index')->name('product');
Route::get('product', 'ProductController@index')->name('product');
Route::post('product/store', 'ProductController@store')->name('product.store');
Route::get('product/edit/{id}', 'ProductController@edit')->name('product.edit');
Route::get('product/delete/{id}', 'ProductController@destroy')->name('product.destroy');
Route::get('product/json','ProductController@json')->name('product.json');
Route::get('user', 'UserController@index')->name('user')->middleware('admin');
Route::post('user/store', 'UserController@store')->name('user.store')->middleware('admin');
Route::get('user/edit/{id}', 'UserController@edit')->name('user.edit')->middleware('admin');
Route::get('user/delete/{id}', 'UserController@destroy')->name('user.destroy')->middleware('admin');
Route::get('user/trashed/{id}', 'UserController@trashed')->name('user.trashed')->middleware('admin');
Route::get('user/restore/{id}', 'UserController@restore')->name('user.restore')->middleware('admin');
Route::get('user/json','UserController@json')->name('user.json')->middleware('admin');
Route::get('mail', 'MailController@index')->name('mail');
