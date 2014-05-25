<?php

class CMS {

	public $user_can_edit = true; // @todo Actually check for this...
	public $sitemap;

	public function __construct()
	{
		// TODO...
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

		$new_pages = [];

		foreach ($pages as $page) {
            $segments = explode('/', $page['url']);

            if(!isset($page['children']))
            {
                $page['children'] = [];
            }

            if(!isset($new_pages[$segments[0]]))
            {
				$new_pages[$segments[0]] = [];
			}

			$current = &$new_pages;
			for ($i=0; $i < count($segments); $i++) {

				$segment = $segments[$i];
				if(!isset($current[$segment])) {
					$current[$segment] = [];
				}

				if($i === count($segments)-1) {
					array_push($current[$segment], $page);
				}

				$current = &$current[$segment];
			}

		}

		$this->sitemap = $new_pages; // "Cache" this
		return $new_pages;
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

		//echo '<pre>'; print_r($this->sitemap); echo'</pre>';

        function echoChildren($item, $nestlevel, $html)
        {
        	if(isset($item['title']))
        	{
        		$html .= "<li>\n";
        		$html .= "<a href='" . URL::to($item['url']) . "'>\n";
        		$html .= $item['title'];
        		$html .= "</a>\n";
        		$html .= "</li>\n";
        	}

			foreach ($item as $child)
            {
                if(is_array($child))
                {
                	if(isset($child[0]['title']) && count($child) > 1) $html .= "<ul>\n"; // TODO: This is ugly clean up lated
                    $html .= echoChildren($child, $nestlevel+1, '');
                    if(isset($child[0]['title']) && count($child) > 1) $html .= "</ul>\n"; // TODO: This is ugly clean up lated
                }
			}

			return $html;
		}

		$html = "<ul>\n";
		$html .= echoChildren($this->sitemap, 0, '');
		$html .= "</ul>\n";

		return $html;
	}

	public function getUrlForPage($id)
	{
		$data = Page::find($id)->toArray();
		$url  = $data['url'];

		return $url;
	}

}

