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

Route::get('/', function(){return View::make('hello');});

//Route::get('/erply', function(){return View::make('test/erply');});

Route::controller('users', 'UsersController');

Route::filter('auth', function()
{
    if (Auth::guest()) return Redirect::guest('/users/login');
});



Route::get('erply', array('before' => 'auth', function()
{
    return View::make('test/erply');
}));