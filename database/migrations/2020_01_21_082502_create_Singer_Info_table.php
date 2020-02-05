<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingerInfoTable extends Migration {

	public function up()
	{
		Schema::create('Singer_Info', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('Item_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('sequence');
			$table->string('singed');
			$table->timestamp('created_date');
			$table->string('created_by');
		});
	}

	public function down()
	{
		Schema::drop('Singer_Info');
	}
}