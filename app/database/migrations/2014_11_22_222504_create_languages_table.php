<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

    public function up()
    {
        Schema::create('languages', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 20);
            $table->string('slug', 20)->index();
            $table->integer('sort_order');
        });
    }

    public function down()
    {
        Schema::drop('components');
    }

}