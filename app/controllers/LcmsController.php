<?php

class LcmsController extends BaseController {

	public function getMainPanel()
	{
        return View::make('lcms.main_panel');
	}

	public function pagesIndex()
	{
		return View::make('lcms.pages_index');
	}

	public function createPage()
	{
		echo '<pre>'; print_r($_POST); echo '</pre>';
	}

}
