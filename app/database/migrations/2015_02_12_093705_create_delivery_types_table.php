<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveryTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delivery_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('deliveryTypeID');
			$table->string('code');
			$table->string('name');
			$table->timestamp('added');
			$table->timestamp('lastModified');
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
		Schema::drop('delivery_types');
	}

}
