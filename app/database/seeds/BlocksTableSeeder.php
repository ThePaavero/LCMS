<?php

class BlocksTableSeeder extends Seeder {

	public function run()
	{
		DB::table('blocks')->delete();

		Block::create(array(
				'type'     => 1,
				'page'     => 1,
				'contents' => 'Title Here!'
			));
		Block::create(array(
				'type'     => 2,
				'page'     => 1,
				'contents' => 'Body here, Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
			));
	}
}