<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesDocumentItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_document_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('salesDocumentID');
			$table->integer('productID');
			$table->integer('line');
			$table->integer('serviceID')->nullable();
			$table->string('itemName')->nullable();
			$table->string('code')->nullable();
			$table->integer('vatrateID')->nullable();
			$table->decimal('amount', 10,0)->nullable();
			$table->decimal('fulfilledAmount', 10,0)->nullable();
			$table->decimal('price', 10,2)->nullable();
			$table->decimal('discount', 10,2)->nullable();
			$table->decimal('finalNetPrice', 10,2)->nullable();
			$table->decimal('finalPriceWithVAT', 10,2)->nullable();
			$table->decimal('rowNetTotal', 10,2)->nullable();
			$table->decimal('rowVAT', 10,2)->nullable();
			$table->decimal('rowTotal', 10,2)->nullable();
			$table->timestamp('deliveryDate')->nullable();
			$table->integer('returnReasonID')->nullable();
			$table->integer('employeeID')->nullable();
			$table->string('campaignIDs')->nullable();
			$table->integer('containerID')->nullable();
			$table->integer('containerAmount')->nullable();
			$table->integer('originalPriceIsZero')->nullable();
			$table->string('lastFulfilledBy')->nullable();
			$table->timestamp('lastFulfilledDate')->nullable();
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
		Schema::drop('sales_document_items');
	}

}
