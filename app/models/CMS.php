<?php

class CMS {

	public $user_can_edit = true; // @todo Actually check for this...

	public function __construct()
	{
		// TODO...
	}

	public function getAllPages()
	{
		// TODO...
	}

	public function getAllTemplates()
	{
		// TODO...
	}

	public function getAllBlockTypes()
	{
		// TODO...
	}

	public function getBlockType($id = 0)
	{
		// TODO...
	}

	public function getBlock($id = 0)
	{
		// TODO...
	}

	public function getNestedSitemapArray()
	{
		$pages = Page::all()->toArray();
		$nested = array();

		// Sort the pages array by the page's depth (amount of "/"s)
		foreach($pages as $key => $i)
		{
			$depth                = substr_count($i['url'], '/');
			$pages[$key]['depth'] = $depth;
		}

		$pages = subval_sort($pages, 'depth', true);

		// Get ready to grab IDs of pages we'll want to get rid of later on
		// (from the first level of depth in our pages array)
		$ids_to_remove_from_base_array = array();

		// Do an all-times-all iteration...
		foreach($pages as $key_a => $a)
		{
			// What level are we on?
			$level_a = substr_count($a['url'], '/');

			// Loop through all pages...
			foreach($pages as $key_b => $b)
			{
				// What level are we on?
				$level_b = substr_count($b['url'], '/');

				// B must be at correct depth for us (our depth plus one)
				if($level_b != $level_a + 1)
				{
					// Can't be our kid, next please...
					continue;
				}

				// What indicates that B is a child of A?
				$look_for = $a['url'] . '/';

				if(strstr($b['url'], $look_for))
				{
					// B is a child of A
					$pages[$key_b]['parent'] = $a['id'];
				}
			}
		}

		// Move each page with a parent under its parent
		foreach($pages as $key => $i)
		{
			foreach($pages as $xkey => $x)
			{
				if( ! isset($x['parent']))
				{
					continue;
				}

				if($i['id'] === $x['parent'])
				{
					$pages[$key]['children'][] = $x;
					$ids_to_remove_from_base_array[] = $x['id'];
				}
			}
		}

		// Get rid of all pages that have parents from the first level of
		// the pages array
		foreach($ids_to_remove_from_base_array as $id)
		{
			foreach($pages as $key => $i)
			{
				if($i['id'] === $id)
				{
					unset($pages[$key]);
				}
			}
		}

		return $pages;
	}

	public function renderPage($uri = '')
	{
		// Make sure this is a valid URI
		if( ! $page_id = $this->uriToPageId($uri))
		{
			die('lol 404, uri does not exist.');
		}

		// Pull data for this page
		$page = Page::find($page_id);
		$page_data = $page->toArray();

		// Gather all blocks for this page
		$blocks = $page->blocks()->get()->toArray();
		$rendered_blocks = array();

		// Set editable flag
		$editable = true; // @todo This should be true only if admin is logged

		// Iterate them and render their output
		foreach($blocks as $i)
		{
			$type = BlockType::find($i['type']);
			$rendered_blocks[$type['name']] = $this->renderBlockType($type['name'], $i, $editable);
		}

		// Get the template
		$template_data      = $page->template()->get()->toArray()[0];
		$template_file_path = app_path() . '/views/lcms/templates/' . $template_data['name'] . '.blade.php';

		if( ! file_exists($template_file_path))
		{
			die('lol 500, template file does not exist');
		}

		// Throw all of our rendered output to the template
		$to_template = [
			'blocks' => $rendered_blocks
		];

		// Return the rendered template's output
		$page_view = View::make('lcms/templates/' . $template_data['name'], array('data' => $to_template));

		return View::make('maintemplate', array(
			'page'  => 'pages.lcms_container',
			'title' => $page_data['title'],
		))->with(array('cms_template' => $page_view));
	}

	public function uriToPageId($uri = '')
	{
		$data = Page::where('url', $uri)->get()->toArray();

		if(empty($data[0]))
		{
			return false;
		}

		return $data[0]['id'];
	}

	public function renderBlockType($type_name, $block, $editable = false)
	{
		$model_class_name = 'Render' . $type_name;

		if( ! class_exists($model_class_name))
		{
			$block['contents'] = '[ERROR: Render class "' . $model_class_name . '" does not exist]';
			return $block;
		}

		$renderer = new $model_class_name($block, $editable);
		return $renderer->returnBlock();

		return $block;
	}

	public function getBlockOfType($type_name)
	{
		return ':D';
	}

	public function updateContent($block_id, $new_content)
	{
		$block = Block::find($block_id);
		$block->contents = $new_content;
		$block->save();
	}

	public function cloneBlockToHistory($block_id)
	{
		$current = Block::find($block_id);
		$current_content = $current->contents;

		$archived = new BlockHistory;
		$archived->block = $block_id;
		$archived->contents = $current_content;
		$archived->save();
	}

	public function block($id)
	{
		$block = Block::find($id);

		if($this->user_can_edit)
		{
			$block->contents = '<span class="cms_editable" data-id="' . $block->id . '" data-type="Default">' . $block->contents . '</span>';
		}

		return $block->contents;
	}

	public function sitemapAsNavigation()
	{
		$sitemap = $this->getNestedSitemapArray();

		//
	}

}