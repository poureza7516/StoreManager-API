<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityLogTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
		Schema::create(config('activitylog.table_name'), function (Blueprint $table) {
			$table->increments('id');
			$table->integer('causer_id')->unsigned()->index()->nullable();

			$table->string('log_name')->nullable();
			$table->text('description');
			$table->integer('subject_id')->nullable();
			$table->string('subject_type')->nullable();
			$table->string('causer_type')->nullable();
			$table->text('properties')->nullable();

			$table->timestamps();

			$table->index('log_name');
			$table->foreign('causer_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::drop(config('activitylog.table_name'));
	}
}
