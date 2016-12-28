<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PagesController@index');

//Route::get('/index', 'PagesController@index');

Route::get('/home', 'PagesController@vorige_pagina');

Route::get('/individueel', 'PagesController@individueel');

Route::get('/citytrips', 'PagesController@citytrips');

Route::get('/ski', 'PagesController@ski');

Route::get('/all_in', 'PagesController@all_in');

Route::get('/groepen', 'PagesController@groepen');

Route::get('/boeken/{id}', 'PagesController@boeken')->middleware('auth');

Route::get('/betalen/{kamerTypes}/{aantPers}/{reisID}/{totaalPrijs}/{daterange}', 'PagesController@betalen')->middleware('auth');

Route::get('/login', 'PagesController@login');

Route::get('/register', 'PagesController@register');

Route::get('/vakantie/{id}', 'PagesController@toonVakantie');


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');