<?php

class Supplier extends \Eloquent {
	public static function getManageableArray(){
		$suppliers= Supplier::where('manageable','=','Yes')->get(); 
    	//return $suppliers;
    	//$suppliersSelect = array('All Supplier');
		foreach ($suppliers as $supplier){
			$suppliersSelect[$supplier->supplierID] = $supplier->fullName;
		}
		return $suppliersSelect;
	}


	public function users()
    {
        return $this->hasMany('User','supplierID','supplierID');
    }
    public function products()
    {
        return $this->hasMany('Product','productID','productID');
    }


}