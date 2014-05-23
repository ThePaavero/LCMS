<?php

class LcmsController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		$this->cms = new CMS;
		View::share('CMS', $this->cms);
	}

	public function getMainPanel($page_id = 0)
	{
		$data = null;

		if($page_id > 0)
		{
			$data = Page::find($page_id);
		}

        return View::make('lcms.main_panel');
	}

	public function createNewPage($page_id = 0)
	{
		$data = array(
				'templates' => Template::all()->toArray()
			);

		if($page_id > 0)
		{
			$data = Page::find($page_id);
		}

		return View::make('lcms.new_page_form')->with(array('data' => $data));
	}

	public function createNewPageSubmit()
	{
		$page           = new Page;
		$page->title    = Input::get('title');
		$page->url      = Input::get('url');
		$page->template = Input::get('template');
		$page->published = new DateTime;
		$page->save();

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
