<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'SiteController@show');
Route::get('/ceremony','SiteController@viewCeremony')->middleware('web','accessCode');
Route::post('/code', 'SiteController@checkCode')->middleware('web');
Route::post('/rsvp', 'SiteController@rsvp')->middleware('web','accessCode');
