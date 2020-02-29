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
Route::get('/','PagesController@index');

Route::resource('/beers', 'BeersController');
Route::resource('/breweries', 'BreweriesController');
Route::resource('/categories', 'CategoriesController');
Route::resource('/geocodes', 'GeoCodesController');
Route::resource('/styles', 'StylesController');

