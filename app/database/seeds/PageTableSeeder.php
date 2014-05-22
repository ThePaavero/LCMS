<?php

class PageTableSeeder extends Seeder {

	public function run()
	{
		DB::table('pages')->delete();

		Page::create(array(
				'title'       => 'About Us',
				'url'         => 'about_us',
				'template'    => 1,
				'description' => '',
				'published'   => new DateTime
			));

		Page::create(array(
				'title'       => 'Our Services',
				'url'         => 'our_services',
				'template'    => 1,
				'description' => '',
				'published'   => new DateTime
			));

		Page::create(array(
				'title'       => 'Web Development',
				'url'         => 'our_services/web_development',
				'template'    => 1,
				'description' => '',
				'published'   => new DateTime
			));

		Page::create(array(
				'title'       => 'Landing Page',
				'url'         => 'landing_page_test',
				'template'    => 2,
				'description' => 'Landing Page Test Description',
				'published'   => new DateTime
			));
	}
}