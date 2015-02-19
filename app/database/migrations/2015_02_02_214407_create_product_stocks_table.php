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
			$table->decimal('amountInStock',10,0)->nullable();
			$table->decimal('amountReserved',10,0)->nullable();
			$table->decimal('suggestedPurchasePrice',10,2)->nullable();
			$table->decimal('averagePurchasePrice',10,2)->nullable();
			$table->decimal('averageCost',10,2)->nullable();
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
