<?php

class LcmsController extends BaseController {

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
		$data = null;

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

}
