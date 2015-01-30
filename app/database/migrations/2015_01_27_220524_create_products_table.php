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
			$table->integer('productID')->unique();
			$table->string('name')->nullable();
			$table->string('code')->nullable();
			$table->string('ean')->nullable();
			$table->string('nameCN')->nullable();
			$table->integer('supplierID')->nullable();
			$table->string('supplierName')->nullable();
			$table->integer('groupID')->nullable();
			$table->string('groupName')->nullable();
			$table->integer('categoryID')->nullable();
			$table->string('categoryName')->nullable();
			$table->integer('seriesID')->nullable();
			$table->string('seriesName')->nullable();
			$table->integer('unitID')->nullable();
			$table->string('unitName')->nullable();
			$table->float('price')->nullable();
			$table->float('priceWithVat')->nullable();
			$table->float('cost')->nullable();
			$table->string('status')->nullable();
			$table->string('active')->nullable();
			$table->string('displayedInWebshop')->nullable();
			$table->float('vatrate')->nullable();
			$table->string('countryOfOriginID')->nullable();
			$table->string('brandName')->nullable();
			$table->float('netWeight')->nullable();
			$table->float('grossWeight')->nullable();
			$table->float('volume')->nullable();
			$table->text('longdesc')->nullable();
			$table->timestamp('erplyAdded')->nullable();
			$table->timestamp('erplyLastModified')->nullable();
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
