<?php

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$this->call('TemplateTableSeeder');
		$this->command->info('Template table seeded!');
	}
}