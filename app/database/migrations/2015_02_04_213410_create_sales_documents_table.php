<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_documents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('salesDocumentID')->unique();
			$table->string('type')->nullable();
			$table->string('source')->nullable();
			$table->string('exportInvoiceType')->nullable();
			$table->string('currencyCode')->nullable();
			$table->decimal('currencyRate', 10,5)->nullable();
			$table->integer('warehouseID')->nullable();
			$table->string('warehouseName')->nullable();
			$table->integer('pointOfSaleID')->nullable();
			$table->string('pointOfSaleName')->nullable();
			$table->integer('pricelistID')->nullable();
			$table->string('number')->nullable();
			$table->timestamp('date')->nullable();
			$table->integer('clientID')->nullable();
			$table->string('clientName')->nullable();
			$table->string('clientEmail')->nullable();
			$table->string('clientCardNumber')->nullable();
			$table->integer('addressID')->nullable();
			$table->string('address')->nullable();
			$table->integer('clientPaysViaFactoring')->nullable();
			$table->integer('payerID')->nullable();
			$table->string('payerName')->nullable();
			$table->integer('payerAddressID')->nullable();
			$table->string('payerAddress')->nullable();
			$table->integer('payerPaysViaFactoring')->nullable();
			$table->integer('contactID')->nullable();
			$table->string('contactName')->nullable();
			$table->integer('employeeID')->nullable();
			$table->string('employeeName')->nullable();
			$table->integer('projectID')->nullable();
			$table->string('invoiceState')->nullable();
			$table->string('paymentType')->nullable();
			$table->integer('paymentTypeID')->nullable();
			$table->integer('paymentDays')->nullable();
			$table->string('paymentStatus')->nullable();
			$table->integer('previousReturnsExist')->nullable();
			$table->integer('confirmed')->nullable();
			$table->string('notes')->nullable();
			$table->string('internalNotes')->nullable();
			$table->decimal('netTotal', 10,2)->nullable();
			$table->decimal('vatTotal', 10,2)->nullable();
			$table->decimal('rounding', 10,2)->nullable();
			$table->decimal('total', 10,2)->nullable();
			$table->decimal('paid')->nullable();
			$table->decimal('externalNetTotal', 10,4)->nullable();
			$table->decimal('externalVatTotal', 10,4)->nullable();
			$table->decimal('externalRounding', 10,4)->nullable();
			$table->decimal('externalTotal', 10,4)->nullable();
			$table->string('taxExemptCertificateNumber')->nullable();
			$table->integer('packerID')->nullable();
			$table->string('referenceNumber')->nullable();
			$table->decimal('cost', 10,2)->nullable();
			$table->integer('reserveGoods')->nullable();
			$table->timestamp('reserveGoodsUntilDate')->nullable();
			$table->timestamp('deliveryDate')->nullable();
			$table->integer('deliveryTypeID')->nullable();
			$table->string('deliveryTypeName')->nullable();
			$table->string('packingUnitsDescription')->nullable();
			$table->integer('triangularTransaction')->nullable();
			$table->integer('purchaseOrderDone')->nullable();
			$table->integer('transactionTypeID')->nullable();
			$table->string('transactionTypeName')->nullable();
			$table->integer('transportTypeID')->nullable();
			$table->string('transportTypeName')->nullable();
			$table->string('deliveryTerms')->nullable();
			$table->string('deliveryTermsLocation')->nullable();
			$table->string('euInvoiceType')->nullable();
			$table->integer('deliveryOnlyWhenAllItemsInStock')->nullable();
			$table->timestamp('lastModified')->nullable();
			$table->string('lastModifierUsername')->nullable();
			$table->timestamp('added')->nullable();
			$table->string('invoiceLink')->nullable();
			$table->string('receiptLink')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales_documents');
	}

}
