<?php

class DeliveryType extends \Eloquent {
	protected $fillable = [];
	public static function getDeliveryTypeSelect(){
		$deliveryTypes= DeliveryType::all(); 
    	//return $suppliers;
    	$deliveryTypesSelect = array('0'=>'Not Delivered');
		foreach ($deliveryTypes as $deliveryType){
			$deliveryTypesSelect[$deliveryType->deliveryTypeID] = $deliveryType->name;
		}
		return $deliveryTypesSelect;
	}
}