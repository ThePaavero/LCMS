<?php

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

        $this->call('LanguagesTableSeeder');
        $this->command->info('Languages table seeded!');

        $this->call('TemplateTableSeeder');
		$this->command->info('Template table seeded!');

		$this->call('BlockTypesTableSeeder');
		$this->command->info('Block types table seeded!');

		$this->call('BlocksTableSeeder');
		$this->command->info('Blocks table seeded!');

		$this->call('TemplateBlockTypeLinkTableSeeder');
		$this->command->info('Template Block Type Link seeded');

		$this->call('UserRoleSeeder');
		$this->command->info('User roles seeded');

		$this->call('UserSeeder');
		$this->command->info('Users seeded');

		$this->call('ComponentSeeder');
		$this->command->info('Components seeded');
	}
}
