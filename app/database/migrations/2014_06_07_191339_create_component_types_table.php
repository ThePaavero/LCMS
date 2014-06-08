<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComponentTypesTable extends Migration {

	public function up()
	{
		Schema::create('component_types', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->text('name');
		});
	}

	public function down()
	{
		Schema::drop('component_types');
	}
}