<?php

class SalesDocument extends \Eloquent {
	protected $fillable = ['salesDocumentID', 'type', 'source', 'exportInvoiceType', 'currencyCode', 'currencyRate', 'warehouseID', 'warehouseName', 'pointOfSaleID', 'pointOfSaleName', 'pricelistID', 'number', 'date', 'clientID', 'clientName', 'clientEmail', 'clientCardNumber', 'addressID', 'address', 'clientPaysViaFactoring', 'payerID', 'payerName', 'payerAddressID', 'payerAddress', 'payerPaysViaFactoring', 'contactID', 'contactName', 'employeeID', 'employeeName', 'projectID', 'invoiceState', 'paymentType', 'paymentTypeID', 'paymentDays', 'paymentStatus', 'previousReturnsExist', 'confirmed', 'notes', 'internalNotes', 'netTotal', 'vatTotal', 'rounding', 'total', 'paid', 'externalNetTotal', 'externalVatTotal', 'externalRounding', 'externalTotal', 'taxExemptCertificateNumber', 'packerID', 'referenceNumber', 'cost', 'reserveGoods', 'reserveGoodsUntilDate', 'deliveryDate', 'deliveryTypeID', 'deliveryTypeName', 'packingUnitsDescription', 'triangularTransaction', 'purchaseOrderDone', 'transactionTypeID', 'transactionTypeName', 'transportTypeID', 'transportTypeName', 'deliveryTerms', 'deliveryTermsLocation', 'euInvoiceType', 'deliveryOnlyWhenAllItemsInStock', 'lastModified', 'lastModifierUsername', 'added', 'invoiceLink', 'receiptLink', 'amountAddedToStoreCredit', 'amountPaidWithStoreCredit', 'applianceID', 'applianceReference', 'assignmentID', 'vehicleMileage'];
	public function salesDocumentItems()
    {
        return $this->hasMany('SalesDocumentItem','salesDocumentID','salesDocumentID');
    }

    public function products()
    {
        return $this->hasManyThrough('Product', 'SalesDocumentItem');
    }

    public function supplierSalesDocuments(){
    	return $this->hasMany('SupplierSalesDocument','salesDocumentID','salesDocumentID');
    }
    //get current user's sales document item
    public function supplierSalesDocumentItems(){ 
        $items = $this->salesDocumentItems;
        $items = $items->filter(function($item){
            $supplierID = Auth::user()->supplierID;
            if(!is_null($item->product)){
                if($item->product->supplierID==$supplierID||$supplierID==0){
                    return $item;
                }
            }
        });
        return $items;
    }



}