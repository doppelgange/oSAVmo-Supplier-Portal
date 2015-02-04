<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	public static $rules = array(
    'firstname'=>'required|alpha|min:2',
    'lastname'=>'required|alpha|min:2',
    'email'=>'required|email',
    'supplierID'=>'required',
    'password'=>'required|alpha_num|between:6,12|confirmed',
    'password_confirmation'=>'required|alpha_num|between:6,12'//'required|alpha_num|between:6,12'
    );
    protected $fillable = ['lastname','firstname','supplierID','password','email'];

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function supplier()
    {
        return $this->belongsTo('Supplier','supplierID','supplierID');
    }

}
