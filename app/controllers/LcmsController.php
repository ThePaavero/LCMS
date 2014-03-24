<?php

class LcmsController extends BaseController {

	public function getMainPanel()
	{
        return View::make('lcms.main_panel');
	}

}
