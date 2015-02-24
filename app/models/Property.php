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

    //quick get property
    public static function qget($name,$key){
    	return Property::where('name','=',$name)->where('key','=',$key)->first();
    }

    //Get env related settings
    public static function env($name){
    	return Property::where('name','=',$name)->where('key','=',Property::n('EnvIndicator'))->first()->value;
    }
    //Quick set property
    public static function qsave($name,$key,$value,$remarks){
        $property = Property::where('name','=',$name)->where('key','=',$key)->first();
        if(is_null($property)){
            $property = new Property();
            $property->name = $name;
            $property->key = $key;
        }
        $property->value = $value;
        $property->remarks = $remarks;
        $property->save();
        return $property;
    }

}