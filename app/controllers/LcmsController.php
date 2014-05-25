<?php

class LcmsController extends BaseController {

	public function __construct()
	{
        parent::__construct();
	}

	public function getMainPanel($page_id = 0)
	{
		$data = null;

		if($page_id > 0)
		{
			$data = Page::find($page_id);
		}

        return View::make('lcms.main_panel')->with(array('data' => $data, 'page_id' => $page_id));
	}

	public function createNewPage($page_id = 0)
	{
		$data = array(
				'templates' => Template::all()->toArray()
			);

		if($page_id > 0)
		{
			$data['parent'] = $page_id;
		}

		return View::make('lcms.new_page_form')->with(array('data' => $data));
	}

	public function createNewPageSubmit()
	{

		$template_id = Input::get('template');

		$page           = new Page;
		$page->title    = Input::get('title');
		$page->url      = Input::get('url');
		$page->template = $template_id;

		$page->published = new DateTime;

		// Parent? If so, prepend its URL to ours
		$parent_id = (int) Input::get('parent_id');
		if($parent_id > 0)
		{
			$page->url = $this->cms->getUrlForPage($parent_id) . '/' . $page->url;
		}

		$page->save();

		$template = Template::find($template_id);

		$template_blocktypes = TemplateBlockTypeLink::where('template', $template_id)->get()->toArray();

		foreach($template_blocktypes as $template_blocktype)
		{
			$block_type_id = $template_blocktype['id'];
			$block_type = BlockType::find($block_type_id);

			if(isset($block_type))
			{
				$block_type_name = $block_type->name;
			}
			else
			{
				$block_type_name = "what happened?";
			}

			$block = new Block;
			$block->type = $block_type_id;
			$block->contents = $block_type_name;
			$block->page = $page->id;
			$block->save();

			$template_blocktype_link = new TemplateBlockTypeLink;
			$template_blocktype_link->type = $template_blocktype['id'];
			$template_blocktype_link->template = $template->id;
			$template_blocktype_link->save();
		}

		Alert::success('Page created')->flash();
		return Redirect::back();
	}

	public function loadPage($uri = '')
	{
		return (string) $this->cms->renderPage($uri);
	}

	public function updateContent()
	{
		$block_id    = Input::get('block_id');
		$new_content = Input::get('content');

		$this->cms->cloneBlockToHistory($block_id);

		$this->cms->updateContent($block_id, $new_content);

		return Response::json([
				'success'          => true,
				'content_received' => $new_content
			]);
	}

	public function getHistoryForBlock($block_id)
	{
		$data = array(
				'history'     => Block::find($block_id)->hasHistory()->get()->toArray(),
				'block_id'    => $block_id,
				'instance_id' => 'history_' . $block_id
			);

		return View::make('lcms.history_for_block')->with(array('data' => $data));
	}

	public function getVersionForBlock($history_id)
	{
		return BlockHistory::find($history_id)->toJson();
	}

}

