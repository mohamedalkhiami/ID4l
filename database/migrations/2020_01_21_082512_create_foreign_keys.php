<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{

	public function up()
	{
		Schema::table('file_item', function (Blueprint $table) {
			$table->foreign('file_owner')->references('user_id')->on('Users')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('file_item', function (Blueprint $table) {
			$table->foreign('status_id')->references('status_id')->on('item_status')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('file_item', function (Blueprint $table) {
			$table->foreign('sign_id')->references('sign_id')->on('signature_type')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('file_item', function (Blueprint $table) {
			$table->foreign('sign_sequence_id')->references('sign_sequence_id')->on('sign_sequence_')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('singer_info', function (Blueprint $table) {
			$table->foreign('Item_id')->references('id')->on('file_item')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('singer_info', function (Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('Users')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('viewer_info', function (Blueprint $table) {
			$table->foreign('Item_id')->references('id')->on('file_item')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('viewer_info', function (Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('Users')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('message_log', function (Blueprint $table) {
			$table->foreign('Item_id')->references('id')->on('file_item')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('message_log', function (Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('Users')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
		Schema::table('message_log', function (Blueprint $table) {
			$table->foreign('action')->references('action_id')->on('file_action')
				->onDelete('CASCADE')->onUpdate('CASCADE');
		});
	}

	public function down()
	{
		Schema::table('file_item', function (Blueprint $table) {
			$table->dropForeign('file_item_file_owner_foreign');
		});
		Schema::table('file_item', function (Blueprint $table) {
			$table->dropForeign('file_item_status_id_foreign');
		});
		Schema::table('file_item', function (Blueprint $table) {
			$table->dropForeign('file_item_signature_type_foreign');
		});
		Schema::table('file_item', function (Blueprint $table) {
			$table->dropForeign('file_item_sign_sequence_foreign');
		});
		Schema::table('singer_info', function (Blueprint $table) {
			$table->dropForeign('Singer_Info_Item_id_foreign');
		});
		Schema::table('singer_info', function (Blueprint $table) {
			$table->dropForeign('Singer_Info_user_id_foreign');
		});
		Schema::table('viewer_info', function (Blueprint $table) {
			$table->dropForeign('viewer_Info_Item_id_foreign');
		});
		Schema::table('viewer_info', function (Blueprint $table) {
			$table->dropForeign('viewer_info_user_id_foreign');
		});
		Schema::table('message_log', function (Blueprint $table) {
			$table->dropForeign('message_log_Item_id_foreign');
		});
		Schema::table('message_log', function (Blueprint $table) {
			$table->dropForeign('message_log_user_id_foreign');
		});
		Schema::table('message_log', function (Blueprint $table) {
			$table->dropForeign('message_log_action_foreign');
		});
	}
}
