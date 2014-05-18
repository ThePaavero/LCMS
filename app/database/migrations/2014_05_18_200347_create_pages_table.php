<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	public function up()
	{
		Schema::create('pages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('url', 80)->unique();
			$table->string('title');
			$table->text('description');
			$table->integer('template')->unsigned()->index();
			$table->datetime('published');
		});
	}

	public function down()
	{
		Schema::drop('pages');
	}
}