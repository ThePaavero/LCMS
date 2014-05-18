<?php

class TemplateTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('templates')->delete();

		// template_seeder
		Template::create(array(
				'name' => 'default'
			));
	}
}