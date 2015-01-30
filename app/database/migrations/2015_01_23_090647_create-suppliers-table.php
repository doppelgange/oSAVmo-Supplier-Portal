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
		    $table->integer('erplyID');
			$table->integer('supplierID')->unique();
			$table->string('supplierType', 100);
			$table->string('fullName', 100)->nullable();
			$table->string('companyName', 100)->nullable();
			$table->integer('groupID')->nullable();
			$table->string('groupName', 10)->nullable();
			$table->string('manageable',10)->default('No');
			$table->timestamp('erplyLastModified')->nullable();
			$table->timestamp('erplyAdded')->nullable();
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
