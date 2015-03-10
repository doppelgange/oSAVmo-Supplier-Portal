<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWxMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wx_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('toUserName');
			$table->string('fromUserName');
			$table->integer('createTime');
			$table->string('msgType');
			$table->text('content');
			$table->integer('msgId');
			$table->string('picUrl');
			$table->integer('mediaId');
			$table->integer('thumbMediaId');
			$table->string('url');
			$table->string('title');
			$table->string('description');
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
		Schema::drop('wx_messages');
	}

}
