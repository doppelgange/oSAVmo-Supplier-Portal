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

Route::get('/', 'UsersController@dashboard');


/*
|--------------------------------------------------------------------------
| User related Routes
|--------------------------------------------------------------------------
*/
Route::get('/users/login', 'UsersController@login');
Route::get('/users/logout', 'UsersController@logout');
Route::get('/users/dashboard', 'UsersController@dashboard');
Route::post('/users/signin', 'UsersController@signin');
Route::resource('users', 'UsersController');

/*
|--------------------------------------------------------------------------
| Supplier related Routes
|--------------------------------------------------------------------------
*/
Route::post('/suppliers/batch-amend', 'SuppliersController@batchAmend');
Route::resource('suppliers','SuppliersController');

/*
|--------------------------------------------------------------------------
| Products related Routes
|--------------------------------------------------------------------------
*/

Route::get('products/sync', 'ProductsController@sync');
Route::resource('products','ProductsController');

/*
|--------------------------------------------------------------------------
| Other related Routes
|--------------------------------------------------------------------------
*/

Route::filter('auth', function(){
    if (Auth::guest()) return Redirect::guest('/users/login');
});

//Used for testing

Route::get('getSuppliers', array('before' => 'auth', function()
{
    return View::make('test/getSuppliers');
}));

Route::get('getProducts', array( function()
{
    return View::make('test/getProducts');
}));

Route::get('test', array(function()
{
    return View::make('test/test');
}));