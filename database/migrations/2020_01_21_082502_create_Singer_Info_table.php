<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('singer_info');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
