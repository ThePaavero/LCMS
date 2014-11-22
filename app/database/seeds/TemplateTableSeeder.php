<?php

class TemplateTableSeeder extends Seeder {

	public function run()
	{
		DB::table('templates')->delete();

		Template::create(array(
				'name'        => 'basic',
				'description' => 'Basic Template'
			));
		Template::create(array(
				'name'        => 'landing_page',
				'description' => 'Landing Page'
			));
	}
}