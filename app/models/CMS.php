<?php

class CMS {

	public $user_can_edit = false;
	public $sitemap;

	public function __construct()
	{
		if( ! App::runningInConsole())
		{
			$this->pages = $this->getAllPages();
			$this->roles = $this->getRoles();

			$this->user_can_edit = $this->isAdmin();
		}
	}

	public function isRoot()
	{
		return $this->hasRole('Root');
	}

	public function isAdmin()
	{
		return $this->hasRole('Root, Admin');
	}

	public function hasRole($titles = '')
	{
		if($titles === '')
		{
			// Any role will do
			return isset(Auth::user()->role);
		}

		// CSV into array
		$titles = explode(',', $titles);

		$user_role_id = Auth::user()->role;

		$user_role_title = $this->roles[$user_role_id];

		foreach($titles as $id => $val)
		{
			$title = trim($val);
			if($title === $user_role_title)
			{
				return true;
			}
		}

		return false;
	}

	public function getRoles()
	{
		$roles = UserRole::all()->toArray();
		$assoc = [];
		foreach($roles as $role)
		{
			$assoc[$role['id']] = $role['title'];
		}
		return $assoc;
	}

	public function getAllPages()
	{
		if(Cache::has('lcms_all_pages'))
		{
			return Cache::get('lcms_all_pages');
		}

		$pages = Page::all()->toArray();

		Cache::forever('lcms_all_pages', $pages);

		return $pages;
	}

	public function getPublicPages()
	{
		if($this->user_can_edit)
		{
			$pages = Page::all()->toArray();
		}
		else
		{
			$pages = Page::where('published', '<=', new DateTime)->get()->toArray();
		}

		return $pages;
	}

	public function getAllTemplates()
	{
		return Template::all()->toArray();
	}

	public function getAllBlockTypes()
	{
		return BlockType::all()->toArray();
	}

	/**
	 * Get an hierarchical array with all pages
	 *
	 * @return array
	 */
	public function getNestedSitemapArray()
	{
		$cache_key = 'lcms_sitemap_' . ($this->isAdmin() ? 'admin' : 'guest');

		if(Cache::has($cache_key))
		{
			return Cache::get($cache_key);
		}

		if(isset($this->sitemap))
		{
			return $this->sitemap;
		}

		Profiler::startTimer('LCMS getNestedSitemapArray');

		$pages = $this->getPublicPages();

		$new_pages = [];

		foreach ($pages as $page) {
            $segments = explode('/', $page['url']);

            if(!isset($page['children']))
            {
                $page['children'] = [];
            }

            if(!isset($new_pages[$segments[0]]))
            {
				$new_pages[$segments[0]] = [];
			}

			$current = &$new_pages;
			for ($i=0; $i < count($segments); $i++) {

				$segment = $segments[$i];
				if(!isset($current[$segment])) {
					$current[$segment] = [];
				}

				if($i === count($segments)-1) {
					array_push($current[$segment], $page);
				}

				$current = &$current[$segment];
			}

		}

		// "Cache" this
		$this->sitemap = $new_pages;

		// Actually cache the sitemap object
		Cache::forever($cache_key, $this->sitemap);

		Profiler::endTimer('LCMS getNestedSitemapArray');

		return $new_pages;
	}

	public function renderPage($uri = '')
	{
		Profiler::startTimer('LCMS Rendering of page');

		// Make sure this is a valid URI
		if( ! $page_id = $this->uriToPageId($uri))
		{
			App::abort(404, 'Page not found');
		}

		// Pull data for this page
		$page = Page::find($page_id);
		$page_data = $page->toArray();

		// Gather all blocks for this page
		$blocks = $page->blocks()->get()->toArray();
		$rendered_blocks = array();

		// Set editable flag
		$editable = true; // @todo This should be true only if admin is logged

		// Iterate them and render their output
		foreach($blocks as $i)
		{
			$type = BlockType::find($i['type']);
			$rendered_blocks[$type['name']] = $this->renderBlockType($type['name'], $i, $editable);
		}

		// Get the template
		$template_data      = $page->template()->get()->toArray()[0];
		$template_file_path = app_path() . '/views/lcms/templates/' . $template_data['name'] . '.blade.php';

		if( ! file_exists($template_file_path))
		{
			die('lol 500, template file does not exist');
		}

		// Throw all of our rendered output to the template
		$to_template = [
			'blocks' => $rendered_blocks
		];

		// Return the rendered template's output
		$page_view = View::make('lcms/templates/' . $template_data['name'], array('data' => $to_template));

		// Create possible title trail
		$title_trail = $this->buildTitleTrail($page_data);

		Profiler::endTimer('LCMS Rendering of page');

		return View::make('maintemplate', array(
			'page'    => 'pages.lcms_container',
			'title'   => $page_data['title'] . $title_trail,
			'page_id' => $page_data['id'],
		))->with(array('cms_template' => $page_view));
	}

	public function uriToPageId($uri = '')
	{
		Profiler::startTimer('LCMS uriToPageId');

		if($this->user_can_edit)
		{
			$data = Page::where('url', $uri)->get()->toArray();
		}
		else
		{
			$data = Page::where('url', $uri)->where('published', '<=', new DateTime)->get()->toArray();
		}

		if(empty($data[0]))
		{
			return false;
		}

		Profiler::endTimer('LCMS uriToPageId');

		return $data[0]['id'];
	}

	public function renderBlockType($type_name, $block, $editable = false)
	{
		$model_class_name = 'Render' . $type_name;

		if( ! class_exists($model_class_name))
		{
			$model_class_name = 'RenderDefault';
		}

		$renderer = new $model_class_name($block, $editable);
		return $renderer->returnBlock();
	}

	public function updateContent($block_id, $new_content)
	{
		$block = Block::find($block_id);
		$block->contents = $new_content;
		$block->save();
	}

	public function cloneBlockToHistory($block_id)
	{
		$current = Block::find($block_id);
		$current_content = $current->contents;

		$archived = new BlockHistory;
		$archived->block = $block_id;
		$archived->contents = $current_content;
		$archived->save();
	}

	public function block($id)
	{
		$block = Block::find($id);

		if($this->user_can_edit)
		{
			$block->contents = '<span class="cms_editable" data-id="' . $block->id . '" data-type="Default">' . $block->contents . '</span>';
		}

		return $block->contents;
	}

	public function sitemapAsNavigation($home = false)
	{
		$this->sitemap = $this->getNestedSitemapArray();

        function echoChildren($item, $nestlevel, $html)
        {
        	if(isset($item['title']))
        	{
        		$html .= "<li>\n";
        		$html .= "<a href='" . URL::to($item['url']) . "'>\n";
        		$html .= $item['title'] . "\n";
        		$html .= "</a>\n";
        		$html .= "</li>\n";
        	}

			foreach ($item as $child)
            {
                if(is_array($child))
                {
                	$is_new_list = isset($child[0]['title']) && $nestlevel > 0;

                	if($is_new_list) $html .= "<ul>\n";

                    $html .= echoChildren($child, $nestlevel+1, '');

                    if($is_new_list) $html .= "</ul>\n";
                }
			}

			return $html;
		}

		$html = "<ul>\n";

		if($home === true)
		{
			$html .= "<li><a href='" . URL::to('') . "'>Home</a></li>";
		}

		$html .= echoChildren($this->sitemap, 0, '');
		$html .= "</ul>\n";

		return $html;
	}

	public function getUrlForPage($id)
	{
		$data = Page::find($id)->toArray();
		$url  = $data['url'];

		return $url;
	}

	public function getPageProperties($page_id)
	{
		$page = Page::find($page_id)->toArray();
		$templates = $this->getAllTemplates();

		return array(
				'page' => $page,
				'templates' => $templates
			);
	}

	public function deleteChildrenOf($parent_id)
	{
		$kids = $this->getChildrenOf($parent_id);
		$deleted = 0;

		if(empty($kids))
		{
			return $deleted;
		}

		foreach($kids as $i)
		{
			Page::find($i['id'])->delete();
			$deleted ++;
		}

		$this->clearCachedSitemap();

		return $deleted;
	}

	public function unpublishChildrenOf($parent_id)
	{
		$kids = $this->getChildrenOf($parent_id);
		$unpublished = 0;

		if(empty($kids))
		{
			return $unpublished;
		}

		foreach($kids as $i)
		{
			$this->unpublishPage($i['id']);
			$unpublished ++;
		}

		$this->clearCachedSitemap();

		return $unpublished;
	}

	public function updateParentUrlForChildrenOf($parent_id, $parent_url)
	{
		$kids = $this->getChildrenOf($parent_id);
		$updated = 0;

		if(empty($kids))
		{
			return $updated;
		}

		foreach($kids as $i)
		{
			$this->updateParentUrl($i['id'], $parent_url);
			$updated ++;
		}

		$this->clearCachedSitemap();

		return $updated;
	}

	public function updateParentUrl($id, $parent_url)
	{
		// Get me first
		$me = Page::find($id);

		// Break up my URL to segments
		$segments = explode('/', $me->url);

		// Get the last segment, that's our own slug
		$last_segment = end($segments);

		// Replace everything before our own slug with $parent_url
		$my_new_url = $parent_url . '/' . $last_segment;

		$this->clearCachedSitemap();

		$me->url = $my_new_url;
		$me->save();
	}

	public function getChildrenOf($id)
	{
		$parent = Page::find($id);
		$parent_url = $parent->url;

		// If my own URL starts with the parent's URL, we're a kid of it
		$kids = Page::where('url', 'LIKE', $parent_url . '%')->where('url', '!=', $parent_url)->get();

		return $kids;
	}

	public function deletePage($id)
	{
		// Get my kids and delete them first
		$kids_deleted = $this->deleteChildrenOf($id);

		// Then, delete myself
		$page = Page::find($id);
		$page->delete();

		$this->clearCachedSitemap();

		return $kids_deleted;
	}

	public function unpublishPage($page_id)
	{
		// Get my kids and unpublish them first
		$kids_unpublished = $this->unpublishChildrenOf($page_id);

		// Then, unpublish myself
		$page = Page::find($page_id);
        $page->published = '9999-1-1 00:00:00';
        $page->save();

        $this->clearCachedSitemap();

        return $kids_unpublished;
	}

	public function updatePage($id, $data)
	{
		// Get my kids and update their URLs first
		$kids_updated = $this->updateParentUrlForChildrenOf($id, $data['url']);

		// Then, update my data
		$page = Page::find($id);
		$page->fill($data);
		$page->save();

		$this->clearCachedSitemap();
	}

	public function clearCachedSitemap()
	{
		Cache::forget('lcms_all_pages');
		Cache::forget('lcms_sitemap_admin');
		Cache::forget('lcms_sitemap_guest');
	}

	public function createNewPage($data)
	{
		$template_id = $data['template'];

		$page            = new Page;
		$page->title     = $data['title'];
		$page->url       = $data['url'];
		$page->published = $data['published'];
		$page->template  = $template_id;

		$page->save();

		$this->clearCachedSitemap();

		$template_blocktypes = TemplateBlockTypeLink::where('template', $template_id)->get()->toArray();

		foreach($template_blocktypes as $template_blocktype)
		{
			$block_type_id = $template_blocktype['id'];

			$block = new Block;
			$block->type = $block_type_id;
			$block->contents = BlockType::find($block_type_id)->name;
			$block->page = $page->id;
			$block->save();
		}

		return $page->url;
	}

	public function buildTitleTrail($page_data)
	{
		$trail = '';

		$page_url = $page_data['url'];
		$depth = substr_count($page_url, '/');

		if($depth < 1)
		{
			return '';
		}

		$segments = explode('/', $page_url);

		array_pop($segments);

		$parent_url = implode('/', $segments);

		$pages = $this->pages;

		foreach($pages as $page)
		{
			if($page['url'] === $parent_url)
			{
				$trail .= ' | ' . $page['title'];
				$trail .= $this->buildTitleTrail($page);
			}
		}

		return $trail;
	}

}

