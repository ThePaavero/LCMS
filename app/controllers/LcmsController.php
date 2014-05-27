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
		$date = new DateTime;
		$published = $date->format('Y-m-d H:i:s');
		$data = array(
				'templates' => Template::all()->toArray(),
				'published' => $published
			);

		if($page_id > 0)
		{
			$data['parent'] = $page_id;
			$data['parent_url'] = Page::find($page_id)->url;
		}

		return View::make('lcms.new_page_form')->with(array('data' => $data));
	}

	public function createNewPageSubmit()
	{
		$template_id = Input::get('template');

		$page            = new Page;
		$page->title     = Input::get('title');
		$page->url       = Input::get('url');
		$page->published = Input::get('published');
		$page->template  = $template_id;

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

			$block = new Block;
			$block->type = $block_type_id;
			$block->contents = BlockType::find($block_type_id)->name;
			$block->page = $page->id;
			$block->save();
		}

		Alert::success('Page created')->flash();
		return Redirect::to($page->url);
	}

	public function loadPage($uri = '')
	{
		return (string) $this->cms->renderPage($uri);
	}

	public function deletePage($page_id)
	{
		$kids_deleted = $this->cms->deletePage($page_id);

		Alert::success('Page deleted (and ' . $kids_deleted . ' children)')->flash();
		return Redirect::to('');
	}

    public function unpublishPage($page_id)
    {
        $kids_unpublished = $this->cms->unpublishPage($page_id);

        Alert::success('Page unpublished (and ' . $kids_unpublished . ' children)')->flash();
        return Redirect::back();
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

	public function editPageProperties($page_id)
	{
		$data = $this->cms->getPageProperties($page_id);
		return View::make('lcms.page_properties')->with(array('data' => $data));
	}

	public function editPagePropertiesSubmit()
	{
		$page_id = Input::get('page_id');

		$page = Page::find($page_id);

		$page->url         = Input::get('url');
		$page->title       = Input::get('title');
		$page->description = Input::get('description');
		$page->template    = Input::get('template');
		$page->published   = Input::get('published');

		$page->save();

		Alert::success('Page properties updated')->flash();
		return Redirect::to($page->url);
	}

}

