<?php

class LcmsController extends BaseController
{

    public function __construct()
    {
        $this->cms = new Lcms;
        View::share('CMS', $this->cms);

        parent::__construct();
    }

    public function getMainPanel($page_id = 0)
    {
        $this->requireAdminRights();

        $data = null;

        if ($page_id > 0)
        {
            $data = $this->cms->getPageProperties($page_id);
        }

        return View::make('lcms.main_panel')->with(array ('data' => $data, 'page_id' => $page_id));
    }

    public function createNewPage($page_id = 0)
    {
        $this->requireAdminRights();

        $date = new DateTime;
        $published = '9999-1-1 00:00:00'; // "unpublished" as default
        $data = array (
            'templates' => Template::all()->toArray(),
            'published' => $published,
            'languages' => Language::all()->toArray()
        );

        if ($page_id > 0)
        {
            $page = Page::find($page_id);

            $data['parent'] = $page_id;
            $data['parent_url'] = $page->url;
            $data['parent_language'] = $page->language()->get()->toArray()[0]['id'];
        }

        return View::make('lcms.new_page_form')->with(array ('data' => $data));
    }

    public function createNewPageSubmit()
    {
        $this->requireAdminRights();

        $data = [
            'template' => Input::get('template'),
            'title' => Input::get('title'),
            'url' => Input::get('url'),
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

        $block_id = Input::get('block_id');
        $new_content = Input::get('content');

        $this->cms->cloneBlockToHistory($block_id);

        $this->cms->updateContent($block_id, $new_content);

        return Response::json([
            'success' => true,
            'content_received' => $new_content
        ]);
    }

    public function getHistoryForBlock($block_id)
    {
        $this->requireAdminRights();

        $data = array (
            'history' => Block::find($block_id)->hasHistory()->get()->toArray(),
            'block_id' => $block_id,
            'instance_id' => 'history_' . $block_id
        );

        return View::make('lcms.history_for_block')->with(array ('data' => $data));
    }

    public function listUsers()
    {
        $this->requireRootRights();

        $data = array (
            'users' => $this->cms->getAllUsers()
        );

        return View::make('lcms.user_list')->with(array ('data' => $data));
    }

    public function getUserForm($user_id)
    {
        $this->requireRootRights();

        $data = array (
            'user' => $this->cms->getSingleUser($user_id),
            'roles' => $this->cms->getRoles()
        );

        return View::make('lcms.user_form')->with(array ('data' => $data));
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
        return View::make('lcms.page_properties')->with(array ('data' => $data));
    }

    public function editPagePropertiesSubmit()
    {
        $this->requireAdminRights();

        $page_id = Input::get('page_id');

        $this->cms->updatePage($page_id, array (
            'language' => Input::get('language'),
            'url' => Input::get('url'),
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'template' => Input::get('template'),
            'published' => Input::get('published')
        ));

        Alert::success('Page properties updated')->flash();
        return Redirect::to(Input::get('url'));
    }

    public function flushAllCaches()
    {
        $this->requireAdminRights();

        $this->cms->clearAllCaches();

        Alert::success('All caches flushed')->flash();
        return Redirect::back();
    }

    private function requireAdminRights()
    {
        if ( ! $this->cms->isAdmin())
        {
            App::abort(404, 'Page not found');
            exit;
        }
    }

    private function requireRootRights()
    {
        if ( ! $this->cms->isRoot())
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
            'email' => Input::get('email'),
            'role' => Input::get('role'),
            'password' => Input::get('password')
        ];

        if ($data['password'] !== '')
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
        $this->requireRootRights();

        $this->cms->deleteUser($id);

        Alert::success('User deleted')->flash();
        return Redirect::back();
    }

    public function deleteComponent($component_id, $page_id)
    {
        $this->requireAdminRights();

        $this->cms->unlinkComponentFromPage($component_id, $page_id);

        Alert::success('Component deleted')->flash();
        return Redirect::back();
    }

    public function createNewComponent($component_type_id, $page_id)
    {
        $this->requireAdminRights();

        $this->cms->createNewComponent($component_type_id, $page_id);

        Alert::success('Component created')->flash();
        return Redirect::back();
    }

    public function languagesListAndForm()
    {
        $this->requireAdminRights();

        $data = [
            'languages' => Language::all()->toArray()
        ];

        return View::make('lcms.language_list_and_form')->with(array ('data' => $data));
    }

    public function createNewLanguage()
    {
        $this->requireAdminRights();

        $data = [
            'name' => Input::get('name'),
            'slug' => Input::get('slug'),
            'sort_order' => Input::get('sort_order'),
        ];

        $lang = new Language;
        $lang->fill($data);
        $lang->save();

        Alert::success('Language added')->flash();
        return Redirect::back();
    }

    public function deleteLanguage($id)
    {
        $this->requireAdminRights();

        $this->cms->deleteLanguage($id);

        Alert::success('Language deleted')->flash();
        return Redirect::back();
    }

    public function managePageOrder()
    {
        $this->requireAdminRights();

        $data = [
            'pages' => $this->cms->sitemapAsNavigation()
        ];

        return View::make('lcms.manage_page_order')->with(array ('data' => $data));
    }

}

