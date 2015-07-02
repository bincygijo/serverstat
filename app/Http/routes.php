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

Route::get('/', function()
{
	$servers = DB::table('servers')->lists('server', 'id');
	return View::make('home', array('server_statistics' => "", 'servers' => $servers, 'server_id' => ""));
});

Route::get('/pull-servers', function()
{
	$servers = DB::table('servers')->lists('server', 'id');
	return View::make('pull-servers', array('servers' => $servers));
});

Route::get('/view-stat/{id}', array('as' => 'view-server-stat', 'uses' => 'HomeController@viewServerStat'));


Route::get('/reload-servers', array('as' => 'reload-servers', 'uses' => 'HomeController@fetchServers'));

Route::post('/fetch-stat', array('as' => 'fetch-stat', 'uses' => 'HomeController@fetchServerStat'));

Route::get('/load-ajax-list', function()
{
	$servers = DB::table('servers')->lists('server', 'id');
	return View::make('pull-servers-ajax', array('servers' => $servers));
});

//Route::get('/load-ajax-stat/{id}', array('as' => 'ajax-view-server-stat', 'uses' => 'HomeController@viewServerStat'));


Route::get('/documentation', function()
{
	return View::make('documentation');
});