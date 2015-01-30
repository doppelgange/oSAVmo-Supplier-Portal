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
			$table->string('productID', 10)->unique();
			$table->string('name')->nullable();
			$table->string('code')->nullable();
			$table->string('ean')->nullable();
			$table->string('nameCN')->nullable();
			$table->string('supplierID', 10)->nullable();
			$table->string('supplierName')->nullable();
			$table->string('groupID', 10)->nullable();
			$table->string('groupName')->nullable();
			$table->string('categoryID', 10)->nullable();
			$table->string('categoryName')->nullable();
			$table->string('seriesID', 10)->nullable();
			$table->string('seriesName')->nullable();
			$table->string('unitID', 10)->nullable();
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
