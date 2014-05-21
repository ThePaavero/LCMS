<?php

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$this->call('TemplateTableSeeder');
		$this->command->info('Template table seeded!');

		$this->call('PageTableSeeder');
		$this->command->info('Pages table seeded!');

		$this->call('BlockTypesTableSeeder');
		$this->command->info('Block types table seeded!');

		$this->call('BlocksTableSeeder');
		$this->command->info('Blocks table seeded!');
	}
}