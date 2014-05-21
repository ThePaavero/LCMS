<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('pages', function(Blueprint $table) {
			$table->foreign('template')->references('id')->on('templates')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('blocks', function(Blueprint $table) {
			$table->foreign('type')->references('id')->on('block_types')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('blocks', function(Blueprint $table) {
			$table->foreign('page')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('pages', function(Blueprint $table) {
			$table->dropForeign('pages_template_foreign');
		});
		Schema::table('blocks', function(Blueprint $table) {
			$table->dropForeign('blocks_type_foreign');
		});
		Schema::table('blocks', function(Blueprint $table) {
			$table->dropForeign('blocks_page_foreign');
		});
	}
}