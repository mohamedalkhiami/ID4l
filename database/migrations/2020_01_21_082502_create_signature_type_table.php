<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatureTypeTable extends Migration {

	public function up()
	{
		Schema::create('signature_type', function(Blueprint $table) {
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
		Schema::drop('signature_type');
	}
}