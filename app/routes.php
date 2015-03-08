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

Route::get('admin/init', 'AdminController@init');
Route::resource('admin','AdminController');

Route::get('users/login', 'UsersController@login');
Route::get('users/logout', 'UsersController@logout');
Route::post('users/signin', 'UsersController@signin');
//Wechat 
//Admin Wechat
Route::resource('wechat', 'WechatController');

Route::group(array('before' => 'auth'), function()
{
    //User related Routes
    Route::put('/users/changePassword/{id}', 'UsersController@changePassword');
	Route::get('/', 'ProductsController@index');
	Route::get('users/dashboard', 'UsersController@dashboard');
	Route::resource('users', 'UsersController');

	//Supplier related Routes
	Route::get('suppliers/sync', 'SuppliersController@sync');
	Route::post('/suppliers/batch-amend', 'SuppliersController@batchAmend');
	Route::resource('suppliers','SuppliersController');

	//Products related Routes
	Route::put('products/inventoryAdjustment', 'ProductsController@inventoryAdjustment');
	Route::get('products/sync', 'ProductsController@sync');
	Route::resource('products','ProductsController');

	//ProductStocks 
	Route::get('productStocks/sync', 'ProductStocksController@sync');
	Route::resource('productStocks', 'ProductStocksController');

	//SalesDocument
	Route::get('salesDocuments/sync', 'SalesDocumentsController@sync');
	Route::resource('salesDocuments', 'SalesDocumentsController');
	//SalesDocumentItem
	Route::resource('salesDocumentItems', 'SalesDocumentItemsController');

	//Supplier SalesDocument
	Route::get('supplierSalesDocuments/{id}/fulfill', 'SupplierSalesDocumentsController@fulfill');
	Route::get('supplierSalesDocuments/sync', 'SupplierSalesDocumentsController@sync');
	Route::resource('supplierSalesDocuments', 'SupplierSalesDocumentsController');

	//Log
	Route::resource('actionLogs', 'ActionLogsController');

	//Price List Item
	Route::get('priceListItems/sync', 'PriceListItemsController@sync');
	Route::resource('priceListItems', 'PriceListItemsController');

	//Admin properties
	Route::resource('properties', 'PropertiesController');

	//Supporting Data - deliveryTypes
	Route::get('deliveryTypes/sync', 'DeliveryTypesController@sync');
	Route::resource('deliveryTypes', 'DeliveryTypesController');

	//Other related Routes
	Route::filter('auth', function(){
	    if (Auth::guest()) return Redirect::guest('/users/login');
	});
});


//Used for testing
Route::get('getInventoryWriteOffs', array(function(){return View::make('test/getInventoryWriteOffs');}));
Route::get('getReasonCodes', array(function(){return View::make('test/getReasonCodes');}));
Route::get('saveInventoryWriteOff', array(function(){return View::make('test/saveInventoryWriteOff');}));
Route::get('saveInventoryRegistration', array(function(){return View::make('test/saveInventoryRegistration');}));
Route::get('getInventoryRegistrations', array( function(){return View::make('test/getInventoryRegistrations');}));
Route::get('getProductStock', array( function(){return View::make('test/getProductStock');}));
Route::get('getProducts', array( function(){return View::make('test/getProducts');}));
Route::get('getSalesDocuments', array( function(){return View::make('test/getSalesDocuments');}));
Route::get('getPriceLists', array( function(){return View::make('test/getPriceLists');}));


// Route::get('getProductPictures', array( function(){return View::make('test/getProductPictures');}));
Route::get('test', array(function(){return View::make('test/test');}));

// Route::get('savePriceList', array(function(){return View::make('test/savePriceList');}));


// Display all SQL executed in Eloquent
// Event::listen('illuminate.query', function($query)
// {
//     var_dump($query);
// });