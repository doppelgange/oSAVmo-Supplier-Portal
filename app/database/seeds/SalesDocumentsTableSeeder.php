<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class SalesDocumentsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			SalesDocument::create([
				'salesDocumentID' => $faker -> unique()->randomDigitNotNull,
				'type' => $faker-> shuffle(array('WayBill', 'Order', 'Bill','TaxWayBill')),
				'source' => $faker ->swiftBicNumber ,
				'exportInvoiceType' => $faker -> shuffle(array('WayBill', 'Order', 'Bill','TaxWayBill')) ,
				'currencyCode' => $faker ->currencyCode,
				'currencyRate' => $faker -> randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 100),
				'warehouseID' => 1,
				'warehouseName' => 'Petone',
				'pointOfSaleID' => $faker ->randomDigitNotNull  ,
				'pointOfSaleName' => $faker ->name ,
				'pricelistID' => $faker ->randomDigitNotNull ,
				// 'number' => $faker ->vat ,
				'date' => $faker ->dateTime($max = 'now') ,
				'clientID' => $faker ->randomDigitNotNull ,
				'clientName' => $faker ->name ,
				'clientEmail' => $faker ->email ,
				'clientCardNumber' => $faker ->creditCardNumber ,
				'addressID' => $faker ->randomDigitNotNull ,
				'address' => $faker ->address ,
				'clientPaysViaFactoring' => '' ,
				'payerID' => $faker ->randomDigitNotNull ,
				'payerName' => $faker ->name ,
				'payerAddressID' => $faker ->randomDigitNotNull ,
				'payerAddress' => $faker ->address ,
				// 'payerPaysViaFactoring' => $faker -> ,
				'contactID' => $faker ->randomDigitNotNull ,
				'contactName' => $faker ->name ,
				'employeeID' => $faker ->randomDigitNotNull ,
				'employeeName' => $faker ->name ,
				'projectID' => $faker ->randomDigitNotNull ,
				'paymentTypeID' => $faker ->randomDigitNotNull ,
				'notes' => $faker ->text ,
				'internalNotes' => $faker ->text ,
				'netTotal' => $faker ->numberBetween($min = 1, $max = 900) ,
				'vatTotal' => $faker ->numberBetween($min = 1, $max = 900) ,
				'rounding' => $faker ->numberBetween($min = 0, $max = 1) ,
				'total' => $faker ->numberBetween($min = 1, $max = 900) ,
				'paid' => $faker ->numberBetween($min = 1, $max = 900) ,
				'externalNetTotal' => $faker ->numberBetween($min = 1, $max = 900) ,
				'externalVatTotal' => $faker -> numberBetween($min = 1, $max = 900),
				'externalRounding' => $faker -> numberBetween($min = 0, $max = 1),
				// 'externalTotal' => $faker -> ,
				// 'taxExemptCertificateNumber' => $faker ->vat ,
				'packerID' => $faker ->randomDigitNotNull ,
				// 'referenceNumber' => $faker ->vat ,
				// 'cost' => $faker -> ,
				// 'reserveGoods' => $faker -> ,
				'reserveGoodsUntilDate' => $faker ->dateTime($max = 'now') ,
				'deliveryDate' => $faker ->dateTime($max = 'now') ,
				'deliveryTypeID' => $faker ->randomDigitNotNull ,
				'deliveryTypeName' => $faker ->name ,
				// 'packingUnitsDescription' => $faker -> ,
				// 'triangularTransaction' => $faker -> ,
				// 'purchaseOrderDone' => $faker -> ,
				'transactionTypeID' => $faker ->randomDigitNotNull ,
				'transactionTypeName' => $faker ->name ,
				// 'transportTypeID' => $faker -> ,
				'transportTypeName' => $faker ->name ,
				// 'deliveryTerms' => $faker -> ,
				// 'deliveryTermsLocation' => $faker -> ,
				// 'euInvoiceType' => $faker -> ,
				// 'deliveryOnlyWhenAllItemsInStock' => $faker -> ,
				'lastModified' => $faker ->dateTime($max = 'now') ,
				'lastModifierUsername' => $faker ->name ,
				'added' => $faker -> dateTime($max = 'now'),
				'invoiceLink' => $faker ->imageUrl(60, 60, 'cats') ,
				'receiptLink' => $faker ->imageUrl(60, 60, 'cats')  ,
				// 'amountAddedToStoreCredit' => $faker -> ,
				// 'amountPaidWithStoreCredit' => $faker -> ,
				'applianceID' => $faker ->randomDigitNotNull ,
				// 'applianceReference' => $faker -> ,
				'assignmentID' => $faker ->randomDigitNotNull ,
				// 'vehicleMileage' => $faker -> ,
			]);
		}
	}

}