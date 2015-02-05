<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductStocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_stocks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('productID');
			$table->integer('warehouseID');
			$table->float('amountInStock')->nullable();
			$table->float('amountReserved')->nullable();
			$table->float('suggestedPurchasePrice')->nullable();
			$table->float('averagePurchasePrice')->nullable();
			$table->float('averageCost')->nullable();
			$table->timestamp('firstPurchaseDate')->nullable();
			$table->timestamp('lastPurchaseDate')->nullable();
			$table->timestamp('lastSoldDate');
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
		Schema::drop('product_stocks');
	}

}
