<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopifypriceToPriceListItem extends Migration {

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
			$table->decimal('shopifyPriceWithGST', 10,2)->nullable()->after('priceWithVat');
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
			$table->dropcolumn('shopifyPriceWithGST');
		});
	}

}
