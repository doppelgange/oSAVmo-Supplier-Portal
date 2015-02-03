<?php

class ProductStock extends \Eloquent {
	protected $fillable = [];

	public function product()
    {
        return $this->belongsTo('Product','productID','productID');
    }
}