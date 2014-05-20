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

		// Gather all blocks for this page
		$blocks = $page->blocks()->get()->toArray();

		$rendered_blocks = array();

		// Iterate them and render their output
		foreach($blocks as $i)
		{
			$type = BlockType::find($i['type']);
			$rendered_blocks[$type['name']] = $this->tempRender($i);
		}

		echo '<pre>'; print_r($rendered_blocks); echo '</pre>';

		// Get the template
		// Throw all of our rendered output to the template
		// Return the rendered template's output
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

	public function tempRender($block)
	{
		// @todo This is just a temp method, these will have their own
		// "plugin" classes for each block type...
		return $block;
	}

}