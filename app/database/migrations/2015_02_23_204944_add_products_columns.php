<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductsColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('products', function(Blueprint $table)
		{
			$table->string('tags')->nullable()->after('longdesc');
    			$table->integer('shopifyID')->nullable()->after('productID');
    			$table->integer('shopifyCollectID')->nullable()->after('shopifyID');
    			$table->integer('shopifyVariantID')->nullable()->after('shopifyCollectID');
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
		Schema::table('products', function(Blueprint $table)
		{
			 $table->dropColumn(array('shopifyId', 'shopifyCollectId', 'shopifyVariationId','tags'));
		});
	}

}
