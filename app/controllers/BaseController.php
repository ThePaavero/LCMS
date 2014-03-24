<?php

class BaseController extends Controller {

	public function __construct()
	{
		/**
		 * Create a common user instance for quicker
		 * user stuff in your controllers.
		 *
		 * @var Object
		 */
		$this->user = Sentry::getUser();
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