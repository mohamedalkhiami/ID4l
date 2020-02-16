<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSignSequenceTable extends Migration
{

	public function up()
	{
		Schema::create('sign_sequence_', function (Blueprint $table) {
			$table->increments('sign_sequence_id');
			$table->string('sign_sequence_display');

			$table->timestamp('created_date')->useCurrent();
			$table->string('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->string('Modified_by');
		});
	}

	public function down()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('sign_sequence_');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
