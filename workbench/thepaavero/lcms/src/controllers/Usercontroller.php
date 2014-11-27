<?php

class UserController extends BaseController {

	public function login()
	{
		return View::make('maintemplate', array(
			'page'  => 'pages.login',
			'title' => 'Login'
		));
	}

	public function loginSubmit()
	{
		$validator = $this->getLoginValidator();

		if($validator->passes())
		{
			$credentials = [
				'username' => Input::get('username'),
				'password' => Input::get('password')
			];

			if(Auth::attempt($credentials))
			{
				Alert::success('You are now logged in')->flash();
				return Redirect::to('');
			}

			Alert::error('Please check your username and/or password')->flash();
			return Redirect::back();
		}
		else
		{
			Alert::error('Fill in both your username and your password')->flash();
			return Redirect::back();
		}
	}

	public function logout()
	{
		Auth::logout();

		Alert::success('You are now logged out')->flash();
		return Redirect::to('');
	}

	protected function getLoginValidator()
	{
		return Validator::make(Input::all(), [
			'username' => 'required',
			'password' => 'required'
		]);
	}

}
