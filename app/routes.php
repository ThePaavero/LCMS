<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('/lcms/get_main_panel', 'LcmsController@getMainPanel');
Route::get('/lcms/create_page/{page_id?}', 'LcmsController@createNewPage');
Route::post('/lcms/create_page/{page_id?}', 'LcmsController@createNewPageSubmit');
Route::post('/lcms/update_content', 'LcmsController@updateContent');

Route::get('/{segments}', 'LcmsController@loadPage')->where('segments', '(.*)');
