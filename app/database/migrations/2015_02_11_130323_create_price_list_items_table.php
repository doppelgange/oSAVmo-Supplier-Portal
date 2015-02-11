<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePriceListItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('price_list_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('priceListID');
			$table->string('type');
			$table->decimal('price', 10,4);
			$table->decimal('priceWithVat', 10,2);
			$table->integer('productID');
			$table->integer('ruleID')->nullable();
			$table->decimal('amount', 10,2)->nullable();
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
		Schema::drop('price_list_items');
	}

}
