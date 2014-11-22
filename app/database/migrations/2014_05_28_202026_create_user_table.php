<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("user", function(Blueprint $table) {
			$table->increments("id");
<<<<<<< HEAD
			$table->integer("role");
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
			$table->string("username");
			$table->string("password");
			$table->string("email");
			$table->string("remember_token")->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("user");
	}

}