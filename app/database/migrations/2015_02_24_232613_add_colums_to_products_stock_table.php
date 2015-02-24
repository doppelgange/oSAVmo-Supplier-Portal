<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToProductsStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('product_stocks', function(Blueprint $table)
		{
			$table->decimal('shopifyAmountInStock',10,0)->nullable()->after('amountInStock');
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
		Schema::table('product_stocks', function(Blueprint $table)
		{
			$table->dropColumn('shopifyAmountInStock');
		});
	}

}
