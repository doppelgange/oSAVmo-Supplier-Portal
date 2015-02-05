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

//No Need auth pages
//Admin page 
Route::get('products/sync/{all}','ProductsController@sync');
Route::resource('admin','AdminController');
Route::get('init', 'AdminController@initiate');

Route::get('users/login', 'UsersController@login');
Route::get('users/logout', 'UsersController@logout');
Route::post('users/signin', 'UsersController@signin');

Route::group(array('before' => 'auth'), function()
{
    //User related Routes
	Route::get('/', 'ProductsController@index');
	Route::get('users/dashboard', 'UsersController@dashboard');
	Route::resource('users', 'UsersController');

	//Supplier related Routes
	Route::post('/suppliers/batch-amend', 'SuppliersController@batchAmend');
	Route::resource('suppliers','SuppliersController');

	//Products related Routes
	Route::get('products/sync', 'ProductsController@sync');
	Route::resource('products','ProductsController');

	//ProductStocks 
	Route::get('productStocks/sync', 'ProductStocksController@sync');
	Route::resource('productStocks', 'ProductStocksController');

	//SalsDocument
	Route::get('salesDocuments/sync', 'SalesDocumentsController@sync');
	Route::resource('salesDocuments', 'SalesDocumentsController');

	//Log
	Route::resource('actionLogs', 'ActionLogsController');

	//Other related Routes
	Route::filter('auth', function(){
	    if (Auth::guest()) return Redirect::guest('/users/login');
	});
});


//Used for testing
Route::get('getSalesDocuments', array(function(){return View::make('test/getSalesDocuments');}));
Route::get('getProductStock', array(function(){return View::make('test/getProductStock');}));
Route::get('getSuppliers', array(function(){return View::make('test/getSuppliers');}));

Route::get('getProducts', array( function(){return View::make('test/getProducts');}));

Route::get('test', array(function(){return View::make('test/test');}));