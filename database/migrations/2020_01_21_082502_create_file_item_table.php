<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileItemTable extends Migration
{

	public function up()
	{
		Schema::create('file_item', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 250);
			$table->integer('file_owner')->unsigned();
			$table->integer('status_id')->unsigned();


			$table->longText('file_url');


			$table->integer('sign_id')->unsigned();
			$table->integer('sign_sequence_id')->unsigned();



			$table->string('total_signer')->nullable();
			$table->string('completed_signer')->nullable();

			$table->string('lock_status')->nullable();
			$table->string('lock_time')->nullable();
			$table->string('lock_code')->nullable();

			$table->timestamp('created_date')->useCurrent()->nullable();
			$table->string('created_by')->nullable();
			$table->timestamp('modified_date')->useCurrent()->nullable();
			$table->string('Modified_by')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('file_item');
	}
}
