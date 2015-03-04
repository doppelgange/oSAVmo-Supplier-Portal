<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToPricelistitem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('price_list_items', function(Blueprint $table)
		{
			$table->decimal('originalPrice', 10,2)->nullable()->after('priceWithVat');
			$table->decimal('discount', 5,2)->nullable()->after('shopifyPriceWithGST');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('price_list_items', function(Blueprint $table)
		{
			$table->dropcolumn('originalPrice','discount');
		});

	}

}
