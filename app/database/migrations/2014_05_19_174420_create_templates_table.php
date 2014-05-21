<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTemplatesTable extends Migration {

	public function up()
	{
		Schema::create('templates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 30);
			$table->text('description')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('templates');
	}
}