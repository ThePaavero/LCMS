<?php

class CMS {

	public $user_can_edit = true; // @todo Actually check for this...
	public $pages;
	public $sitemap;

	public function __construct()
	{
		$this->pages = Page::all()->toArray();
	}

	public function getAllPages()
	{
		return Page::all()->toArray();
	}

	public function getAllTemplates()
	{
		return Template::all()->toArray();
	}

	public function getAllBlockTypes()
	{
		return BlockType::all()->toArray();
	}

	/**
	 * Get an hierarchical array with all pages
	 * Note: This was pretty much cloned from Q2
	 *
	 * @return array
	 */
	public function getNestedSitemapArray()
	{
		if(isset($this->sitemap))
		{
			return $this->sitemap;
		}

		$pages = Page::all()->toArray();
		$depth_array = array();

		foreach($pages as $page)
		{
			$depth = substr_count($page['url'], '/');
			$depth_array[$depth][] = $page;
		}

		$depth_array = array_reverse($depth_array);

		foreach($depth_array as $pages)
		{
			$segments = explode('/', $page['url']);
			array_pop($segments);
			$parent_uri = implode('/', $segments);

			$parent = $this->getPageByUrl($parent_uri);

			//$pages[$xkey]['parent'] = $parent;
		}

		$this->sitemap = $pages; // "Cache" this
		return $pages;
	}

	public function getPageByUrl($url)
	{
		foreach($this->pages as $page)
		{
			if($page['url'] === $url)
			{
				return $page;
			}
		}
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
			'page'    => 'pages.lcms_container',
			'title'   => $page_data['title'],
			'page_id' => $page_data['id'],
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

	public function sitemapAsNavigation($home = false)
	{
		$this->sitemap = $this->getNestedSitemapArray();

		$html = '<ul>';

		if($home === true)
		{
			$html .= '<li><a href="' . URL::to('') . '">Home</a></li>';
		}

		foreach($this->sitemap as $i)
		{
			if(strstr($i['url'], '/'))
			{
				// We only want the first level pages first
				continue;
			}

			$html .= '<li>';
			$html .= '<a href="' . URL::to($i['url']) . '">' . $i['title'] . '</a>';
			$html .= $this->childrenAsList($i); // This is where recursivity kicks in
			$html .= '</li>';
		}

		$html .= '</ul>';

		return $html;
	}

	public function childrenAsList($parent)
	{
		if(empty($parent['children']))
		{
			return '';
		}

		$html = '<ul>';

		foreach($parent['children'] as $child)
		{
			$html .= '<li>';
			$html .= '<a href="' . $child['url'] . '">' . $child['title'] . '</a>';
			$html .= $this->childrenAsList($child);
			$html .= '</li>';
		}

		$html .= '</ul>';

		return $html;
	}

	public function getUrlForPage($id)
	{
		$data = Page::find($id)->toArray();
		$url  = $data['url'];

		return $url;
	}

}