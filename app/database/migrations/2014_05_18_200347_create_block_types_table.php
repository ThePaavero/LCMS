<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlockTypesTable extends Migration {

	public function up()
	{
		Schema::create('block_types', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 30)->index();
		});
	}

	public function down()
	{
		Schema::drop('block_types');
	}
}