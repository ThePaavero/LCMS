<?php

class CMS {

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

		// Iterate them and render their output
		foreach($blocks as $i)
		{
			$type = BlockType::find($i['type']);
			$rendered_blocks[$type['name']] = $this->renderBlockType($type['name'], $i);
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

	public function renderBlockType($type_name, $block)
	{
		$model_class_name = 'Render' . $type_name;

		if( ! class_exists($model_class_name))
		{
			$block['contents'] = '[ERROR: Render class "' . $model_class_name . '" does not exist]';
			return $block;
		}

		$renderer = new $model_class_name($block);
		return $renderer->returnBlock();

		return $block;
	}

}