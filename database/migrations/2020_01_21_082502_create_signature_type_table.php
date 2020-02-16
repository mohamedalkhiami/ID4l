<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSignatureTypeTable extends Migration
{

	public function up()
	{
		Schema::create('signature_type', function (Blueprint $table) {
			$table->increments('sign_id');
			$table->string('sign_type_displays');
			$table->timestamp('created_date')->useCurrent();
			$table->string('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->string('Modified_by');
		});
	}

	public function down()
	{

		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('signature_type');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
