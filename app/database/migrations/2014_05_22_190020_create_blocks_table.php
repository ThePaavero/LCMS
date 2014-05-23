<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlocksTable extends Migration {

	public function up()
	{
		Schema::create('blocks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('type')->unsigned()->index();
			$table->integer('page')->unsigned()->index();
			$table->text('contents');
		});
	}

	public function down()
	{
		Schema::drop('blocks');
	}
}