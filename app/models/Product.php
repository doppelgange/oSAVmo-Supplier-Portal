<?php

class Product extends \Eloquent {
	protected $fillable = [];

	public function productStocks()
    {
        return $this->hasMany('ProductStock','productID','productID');
    }
    public function supplier()
    {
        return $this->belongsTo('Supplier','supplierID','supplierID');
    }
    public function priceListItems()
    {
        return $this->hasMany('PriceListItem','productID','productID');
    }

}