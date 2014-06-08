<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComponentsTable extends Migration {

	public function up()
	{
		Schema::create('components', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('page')->unsigned()->index();
			$table->integer('type')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('components');
	}
}