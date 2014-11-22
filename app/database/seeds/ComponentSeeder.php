<?php

class ComponentSeeder extends DatabaseSeeder {

	public function run()
	{
		$this->createTypes();
		$this->createComponents();
		$this->createContentBlocks();
	}

	public function createTypes()
	{
		$types = [
			[
				'name' => 'Teaser box'
			]
		];

		foreach($types as $type)
		{
			ComponentType::create($type);
		}
	}

	public function createComponents()
	{
		$components = [
			[
				'type' => 1,
				'page' => 1
			],
			[
				'type' => 1,
				'page' => 1
			]
		];

		foreach($components as $component)
		{
			Component::create($component);
		}
	}

	public function createContentBlocks()
	{
		$blocks = [
			[
				'component' => 1,
				'type' => 1,
				'contents' => 'This is the title for a teaser component'
			],
			[
				'component' => 1,
				'type' => 2,
				'contents' => '<p>This is the body for a teaser component.</p>'
			],
			[
				'component' => 2,
				'type' => 1,
				'contents' => 'This is the title for another teaser component'
			],
			[
				'component' => 2,
				'type' => 2,
				'contents' => '<p>This is the body for another teaser component.</p>'
			]
		];

		foreach($blocks as $block)
		{
			Block::create($block);
		}
	}

}