<?php

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$this->call('TemplateTableSeeder');
		$this->command->info('Template table seeded!');

<<<<<<< HEAD
=======
		$this->call('PageTableSeeder');
		$this->command->info('Pages table seeded!');

>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		$this->call('BlockTypesTableSeeder');
		$this->command->info('Block types table seeded!');

		$this->call('BlocksTableSeeder');
		$this->command->info('Blocks table seeded!');

		$this->call('TemplateBlockTypeLinkTableSeeder');
		$this->command->info('Template Block Type Link seeded');

<<<<<<< HEAD
		$this->call('UserRoleSeeder');
		$this->command->info('User roles seeded');

		$this->call('UserSeeder');
		$this->command->info('Users seeded');

		$this->call('ComponentSeeder');
		$this->command->info('Components seeded');
=======
		$this->call('UserSeeder');
		$this->command->info('Users seeded');
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
	}
}
