<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryStatusToSalesDocumentItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sales_document_items', function(Blueprint $table)
		{
			$table->integer('deliveryTypeID');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sales_document_items', function(Blueprint $table)
		{
			$table->dropColumn('deliveryTypeID');
		});
	}

}
