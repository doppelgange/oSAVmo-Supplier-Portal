<?php

class Supplier extends \Eloquent {
	public static function getManageable(){
		$suppliers= Supplier::where('manageable','=','Yes')->get(); 
    	//return $suppliers;
    	$suppliersSelect = array();
		foreach ($suppliers as $supplier){
			$suppliersSelect[$supplier->supplierID] = $supplier->fullName;
		}
		return $suppliersSelect;
	}
}