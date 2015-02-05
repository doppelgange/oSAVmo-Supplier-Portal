<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
			$table->string('module');
			$table->string('from');
			$table->string('to');
			$table->string('notes');
			$table->string('user');
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
		Schema::drop('action_logs');
	}

}
