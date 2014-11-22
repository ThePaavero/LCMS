<?php

class BlocksTableSeeder extends Seeder {

	public function run()
	{
		DB::table('blocks')->delete();

		Block::create(array(
				'type'     => 0,
				'page'     => 0,
				'contents' => 'Editable Header'
			));
		Block::create(array(
				'type'     => 0,
				'page'     => 0,
				'contents' => 'Editable Footer'
			));
	}
}