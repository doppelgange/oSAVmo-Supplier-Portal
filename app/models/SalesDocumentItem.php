<?php

class SalesDocumentItem extends \Eloquent {
	protected $fillable = [];
	public function SalesDocument()
    {
        return $this->belongsTo('SalesDocument','salesDocumentID','salesDocumentID');
    }
    public function product()
    {
        return $this->belongsTo('Product','productID','productID');
    }

}