<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageLogTable extends Migration {

	public function up()
	{
		Schema::create('message_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->integer('Item_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('action')->unsigned();
			$table->string('message');
			$table->timestamp('created_date')->useCurrent();
			$table->string('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->string('Modified_by');
		});
	}

	public function down()
	{
		Schema::drop('message_log');
	}
}