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

Route::get('/', 'HomeController@showWelcome');

Route::controller('users', 'UsersController');
Route::controller('suppliers','SuppliersController');
Route::controller('products','ProductsController');

Route::filter('auth', function(){
    if (Auth::guest()) return Redirect::guest('/users/login');
});



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