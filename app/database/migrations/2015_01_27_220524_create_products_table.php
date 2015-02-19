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
			$table->decimal('price',10,2)->nullable();
			$table->decimal('priceWithVat',10,2)->nullable();
			$table->decimal('cost',10,2)->nullable();
			$table->string('status')->nullable();
			$table->string('active')->nullable();
			$table->string('displayedInWebshop')->nullable();
			$table->decimal('vatrate',10,5)->nullable();
			$table->string('countryOfOriginID')->nullable();
			$table->string('brandName')->nullable();
			$table->decimal('netWeight',10,2)->nullable();
			$table->decimal('grossWeight',10,2)->nullable();
			$table->decimal('volume',10,2)->nullable();
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
