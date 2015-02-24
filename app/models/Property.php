<?php

class Property extends \Eloquent {
	protected $fillable = ['name','key','value','remarks'];
	public static $rules = array(
    'name'=>'required',
    'key'=>'required',
    'value'=>'required',
    'remarks'=>'max:255'
    );

    public static function n($name){
    	return Property::where('name','=',$name)->first()->value;
    }

    public static function nv($name,$key){
    	return Property::where('name','=',$name)->where('key','=',$key)->first()->value;
    }

    public static function env($name){
    	return Property::where('name','=',$name)->where('key','=',Property::n('EnvIndicator'))->first()->value;
    }


}