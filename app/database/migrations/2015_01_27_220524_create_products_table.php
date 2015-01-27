<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('productID');
			$table->string('name');
			$table->string('code');
			$table->string('ean');
			$table->string('nameCN');
			$table->string('supplierID');
			$table->string('supplierName');
			$table->string('groupID');
			$table->string('groupName');
			$table->string('categoryID');
			$table->string('categoryName');
			$table->string('seriesID');
			$table->string('seriesName');
			$table->string('unitID');
			$table->string('unitName');
			$table->float('price');
			$table->float('priceWithVat');
			$table->float('cost');
			$table->string('status');
			$table->string('active');
			$table->string('displayedInWebshop');
			$table->float('vatrate');
			$table->string('countryOfOriginID');
			$table->string('brandName');
			$table->float('netWeight');
			$table->float('grossWeight');
			$table->float('volume');
			$table->text('longdesc');
			$table->dateTime('erplyAdded');
			$table->dateTime('erplyLastModified');
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
		Schema::drop('products');
	}

}
