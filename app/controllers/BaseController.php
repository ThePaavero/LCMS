<?php
use Illuminate\Routing\Controller;

class BaseController extends Controller {

	public function __construct()
	{
		$this->cms = new CMS;
		View::share('CMS', $this->cms);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
