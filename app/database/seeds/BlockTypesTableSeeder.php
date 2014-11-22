<?php

class BlockTypesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('block_types')->delete();

		BlockType::create(array(
				'name' => 'Title'
			));

		BlockType::create(array(
				'name' => 'Body'
			));
	}
}