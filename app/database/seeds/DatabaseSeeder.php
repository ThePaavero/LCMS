<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		// $this->call('AdminuserTableSeeder');
		$this->call('PagesTableSeeder');
		$this->call('ContentsTableSeeder');
		$this->call('Contents_to_pagesTableSeeder');
	}

}