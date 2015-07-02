<?php

Route::group(['prefix' => 'search', 'namespace' => 'Modules\Search\Http\Controllers'], function()
{
	//Route::get('/', 'SearchController@index');
	Route::controller('/', 'SearchController');
});