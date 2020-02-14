<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewerInfoTable extends Migration
{

	public function up()
	{
		Schema::create('viewer_Info', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('Item_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->timestamp('created_date')->useCurrent();
			$table->string('created_by')->nullable();;
			$table->timestamp('modified_date')->useCurrent();
			$table->string('Modified_by')->nullable();;
		});
	}

	public function down()
	{
		Schema::drop('viewer_Info');
	}
}
