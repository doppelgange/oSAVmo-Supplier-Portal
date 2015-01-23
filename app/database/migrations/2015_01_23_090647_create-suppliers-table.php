<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('suppliers', function($table)
	    {
		    $table->increments('id');
		    $table->string('erplyid', 10);
			$table->string('supplierID', 10);
			$table->string('supplierType', 100);
			$table->string('fullName', 100);
			$table->string('companyName', 100);
			$table->string('groupID', 10);
			$table->string('groupName', 10);
			$table->timestamp('erplyLastModified');
			$table->timestamp('erplyAdded');
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
		Schema::drop('suppliers');
	}

}
