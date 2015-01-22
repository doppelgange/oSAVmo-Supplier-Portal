<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
	    {
			$table->increments('id');
		    $table->string('firstname', 100);
		    $table->string('lastname', 100);
		    $table->string('suppliername', 100);
		    $table->string('status', 10);
		    $table->string('email', 100)->unique();
		    $table->string('password', 64);
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
		Schema::drop('users');
	}

}
