<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingerInfoTable extends Migration
{

	public function up()
	{
		Schema::create('singer_info', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('Item_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('sequence')->nullable();;
			$table->string('singed')->nullable();;
			$table->timestamp('created_date')->nullable();;
			$table->string('created_by')->nullable();;
		});
	}

	public function down()
	{
		Schema::drop('singer_info');
	}
}
