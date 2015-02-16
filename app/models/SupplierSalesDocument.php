<?php

class SupplierSalesDocument extends \Eloquent {
	protected $fillable = [];
	public function salesDocument(){
		return $this->belongsTo('SalesDocument','salesDocumentID','salesDocumentID');
	}
	public function supplier(){
		return $this->belongsTo('Supplier','supplierID','supplierID');
	}

	public function salesDocumentItems()
    {
        return $this->hasMany('SalesDocumentItem','salesDocumentID','salesDocumentID');
    }

    public function supplierSalesDocumentItems(){ 
        $items = $this->salesDocumentItems;
        $supplierID = $this->supplierID;
        $items = $items->filter(function($item) use($supplierID ){
            //dd();
            if(!is_null($item->product)){
                if($item->product->supplierID==$supplierID){
                    return $item;
                }
            }
        });
        return $items;
    }

}