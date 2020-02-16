<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

	public function up()
	{
		Schema::create('Users', function (Blueprint $table) {
			$table->increments('user_id');
			$table->string('email');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('Firebase_Token');
			$table->timestamp('created_at')->useCurrent();
			$table->string('created_by');
			$table->timestamp('modified_date')->useCurrent();
			$table->string('Modified_by');
		});
	}

	public function down()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::drop('Users');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
