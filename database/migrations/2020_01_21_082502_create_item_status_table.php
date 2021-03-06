<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateItemStatusTable extends Migration
{

	public function up()
	{
		Schema::create('item_status', function (Blueprint $table) {
			$table->increments('status_id');
			$table->string('status_display');
			$table->string('created_by');
			$table->string('modified_by');
			// $table->timestamp('created_date')->useCurrent();
			// $table->timestamp('modified_date')->useCurrent();
		});
	}

	public function down()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('item_status');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
