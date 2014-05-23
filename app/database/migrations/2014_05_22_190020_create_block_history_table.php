<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlockHistoryTable extends Migration {

	public function up()
	{
		Schema::create('block_history', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('block')->unsigned()->index();
			$table->text('contents');
		});
	}

	public function down()
	{
		Schema::drop('block_history');
	}
}