<?php

class LcmsController extends BaseController {

	public function __construct()
	{
        parent::__construct();
	}

	public function getMainPanel($page_id = 0)
	{
		$this->requireAdminRights();

		$data = null;

		if($page_id > 0)
		{
			$data = $this->cms->getPageProperties($page_id);
		}

        return View::make('lcms.main_panel')->with(array('data' => $data, 'page_id' => $page_id));
	}

	public function createNewPage($page_id = 0)
	{
		$this->requireAdminRights();

		$date = new DateTime;
		$published = '9999-1-1 00:00:00'; // "unpublished" as default
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
		$this->requireAdminRights();

		$data = [
			'template'  => Input::get('template'),
			'title'     => Input::get('title'),
			'url'       => Input::get('url'),
			'published' => Input::get('published'),
			'parent_id' => Input::get('parent_id'),
		];

		$url = $this->cms->createNewPage($data);

		Alert::success('Page created')->flash();
		return Redirect::to($url);
	}

	public function loadPage($uri = '')
	{
		return (string) $this->cms->renderPage($uri);
	}

	public function deletePage($page_id)
	{
		$this->requireAdminRights();

		$kids_deleted = $this->cms->deletePage($page_id);

		Alert::success('Page deleted (and ' . $kids_deleted . ' children)')->flash();
		return Redirect::to('');
	}

    public function unpublishPage($page_id)
    {
    	$this->requireAdminRights();

        $kids_unpublished = $this->cms->unpublishPage($page_id);

        Alert::success('Page unpublished (and ' . $kids_unpublished . ' children)')->flash();
        return Redirect::back();
    }

    public function publishPage($page_id)
    {
    	$this->requireAdminRights();

        $this->cms->publishPage($page_id);

		// Laravel's caching of views doesn't remove the
		// "This page is not publicly visible" message... so sleep a sec.
        sleep(1);

        Alert::success('Page published')->flash();
        return Redirect::back();
    }

	public function updateContent()
	{
		$this->requireAdminRights();

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
		$this->requireAdminRights();

		$data = array(
				'history'     => Block::find($block_id)->hasHistory()->get()->toArray(),
				'block_id'    => $block_id,
				'instance_id' => 'history_' . $block_id
			);

		return View::make('lcms.history_for_block')->with(array('data' => $data));
	}

	public function listUsers()
	{
		$this->requireRootRights();

		$data = array(
				'users' => $this->cms->getAllUsers()
			);

		return View::make('lcms.user_list')->with(array('data' => $data));
	}

	public function getUserForm($user_id)
	{
		$this->requireRootRights();

		$data = array(
				'user' => $this->cms->getSingleUser($user_id),
				'roles' => $this->cms->getRoles()
			);

		return View::make('lcms.user_form')->with(array('data' => $data));
	}

	public function getVersionForBlock($history_id)
	{
		$this->requireAdminRights();

		return BlockHistory::find($history_id)->toJson();
	}

	public function editPageProperties($page_id)
	{
		$this->requireAdminRights();

		$data = $this->cms->getPageProperties($page_id);
		return View::make('lcms.page_properties')->with(array('data' => $data));
	}

	public function editPagePropertiesSubmit()
	{
		$this->requireAdminRights();

		$page_id = Input::get('page_id');

		$this->cms->updatePage($page_id, array(
				'url'         => Input::get('url'),
				'title'       => Input::get('title'),
				'description' => Input::get('description'),
				'template'    => Input::get('template'),
				'published'   => Input::get('published')
			));

		Alert::success('Page properties updated')->flash();
		return Redirect::to(Input::get('url'));
	}

	public function flushAllCaches()
	{
		$this->requireAdminRights();

		Cache::flush();

		Alert::success('All caches flushed')->flash();
		return Redirect::back();
	}

	private function requireAdminRights()
	{
		if( ! $this->cms->isAdmin())
		{
			App::abort(404, 'Page not found');
			exit;
		}
	}

	private function requireRootRights()
	{
		if( ! $this->cms->isRoot())
		{
			App::abort(404, 'Page not found');
			exit;
		}
	}

	public function submitUserForm()
	{
		$this->requireRootRights();
		$id = (int) Input::get('id');

		$data = [
			'username' => Input::get('username'),
			'email'    => Input::get('email'),
			'role'     => Input::get('role'),
			'password' => Input::get('password')
		];

		if($data['password'] !== '')
		{
			$data['password'] = Hash::make($data['password']);
		}
		else
		{
			$data['password'] = Auth::user()->password;
		}

		$user = User::find($id);
		$user->fill($data);
		$user->save();

		Alert::success('User updated')->flash();
		return Redirect::back();
	}

	public function deleteUser($id)
	{
		$this->cms->deleteUser($id);

		Alert::success('User deleted')->flash();
		return Redirect::back();
	}

}

