<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileActionTable extends Migration {

	public function up()
	{
		Schema::create('file_action', function(Blueprint $table) {
			$table->increments('action_id');
			$table->string('action_display');
			$table->string('created_by');
			$table->string('Modified_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->timestamp('created_date')->useCurrent();
			
		});
	}

	public function down()
	{
		Schema::drop('file_action');
	}
}