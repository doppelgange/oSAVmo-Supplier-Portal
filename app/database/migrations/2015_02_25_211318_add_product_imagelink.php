<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductImagelink extends Migration {

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
			$table->string('imageLink')->nullable()->after('tags');
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
			$table->dropcolumn('imageLink');
		});
	}

}
