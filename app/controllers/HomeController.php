<?php

use Demo\Demo\DemoInterface;

class HomeController extends BaseController {

	public function index()
	{
		return View::make('maintemplate', array(
			'page'  => 'pages.home',
			'title' => 'Home'
		));
	}

}