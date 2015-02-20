<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShopifyFiledsToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->integer('shopifyId')->nullable();
			$table->integer('shopifyCollectId')->nullable();
			$table->integer('shopifyVariationId')->nullable();
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function(Blueprint $table)
		{
			 $table->dropColumn(array('shopifyId', 'shopifyCollectId', 'shopifyVariationId'));
		});
	}

}
