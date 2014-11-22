<?php

class LanguagesTableSeeder extends Seeder
{

    public function run()
    {
        Language::create([
            'name' => 'English',
            'slug' => 'en',
            'sort_order' => 1
        ]);

        Language::create([
            'name' => 'Finnish',
            'slug' => 'fi',
            'sort_order' => 2
        ]);

        Language::create([
            'name' => 'Swedish',
            'slug' => 'se',
            'sort_order' => 3
        ]);
    }

}