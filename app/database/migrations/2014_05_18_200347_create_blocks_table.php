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
			$table->string('name', 30)->unique();
			$table->integer('type')->unsigned()->index();
			$table->integer('page')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('blocks');
	}
}