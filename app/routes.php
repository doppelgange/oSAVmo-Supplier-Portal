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

Route::filter('auth', function(){
    if (Auth::guest()) return Redirect::guest('/users/login');
});



Route::get('erply', array('before' => 'auth', function()
{
    return View::make('test/erply');
}));