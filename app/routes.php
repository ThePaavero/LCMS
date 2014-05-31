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

Route::get('login', 'UserController@login');
Route::post('login', 'UserController@loginSubmit');
Route::get('logout', 'UserController@logout');

Route::group(array('before' => 'auth'), function()
{
	Route::get('/lcms/get_main_panel/{page_id?}', 'LcmsController@getMainPanel');
	Route::get('/lcms/flush_all_caches', 'LcmsController@flushAllCaches');

	Route::get('/lcms/create_page/{page_id?}', 'LcmsController@createNewPage');
	Route::post('/lcms/create_page/{page_id?}', 'LcmsController@createNewPageSubmit');

	Route::get('/lcms/unpublish_page/{page_id}', 'LcmsController@unpublishPage');
	Route::get('/lcms/publish_page/{page_id}', 'LcmsController@publishPage');
	Route::get('/lcms/delete_page/{page_id}', 'LcmsController@deletePage');

	Route::get('/lcms/edit_page_properties/{page_id}', 'LcmsController@editPageProperties');
	Route::post('/lcms/update_page', 'LcmsController@editPagePropertiesSubmit');

	Route::post('/lcms/update_content', 'LcmsController@updateContent');
	Route::get('/lcms/get_history_for_block/{block_id}', 'LcmsController@getHistoryForBlock');
	Route::get('/lcms/get_version_of_block/{history_id}', 'LcmsController@getVersionForBlock');

	Route::any('/elfinder/tinymce', 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4');
	Route::any('/elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
});


Route::get('/{segments}', 'LcmsController@loadPage')->where('segments', '(.*)');
