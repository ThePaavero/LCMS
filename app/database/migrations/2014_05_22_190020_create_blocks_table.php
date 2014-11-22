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
<<<<<<< HEAD
			$table->integer('page')->unsigned()->nullable()->index();
			$table->integer('component')->unsigned()->nullable()->index();
=======
			$table->integer('page')->unsigned()->index();
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
			$table->text('contents');
		});
	}

	public function down()
	{
		Schema::drop('blocks');
	}
}