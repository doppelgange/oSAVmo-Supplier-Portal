<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManageableAttributeForSupplier extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('suppliers', function($table)
		{
		    $table->string('manageable')->default('No');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('suppliers', function($table)
		{
		    $table->dropColumn('manageable');
		});
	}

}
