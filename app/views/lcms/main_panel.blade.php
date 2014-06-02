<?php // echo '<pre>'; print_r($data); echo '</pre>'; ?>
<a href='#' class='handle'>
	<span class='handle_content'>≡</span>
</a>

<div class='content'>
	<h2 class='cms_title'>CMS</h2>

	<p class='lcms_panel_meta'>
		You're logged in as "{{ Auth::user()->username }}"
	</p>

	<nav>
		<ul>
			<li><a href='{{ URL::to('lcms/create_page/' . (isset($page_id) ? $page_id : 0)) }}' class='icon_create_new_page'>Create new page here</a></li>
			@if(isset($page_id) && $page_id > 0)
			<li><a href='{{ URL::to('lcms/edit_page_properties/' . $page_id) }}' class='icon_page_properties'>Page properties</a></li>
			@if( ! $data['is_public'])
			<li><a href='{{ URL::to('lcms/publish_page/' . $page_id) }}' class='noajax confirm icon_publish_page'>Publish page</a></li>
			@else
			<li><a href='{{ URL::to('lcms/unpublish_page/' . $page_id) }}' class='noajax confirm icon_unpublish_page'>Unpublish page</a></li>
			@endif
			<li><a href='{{ URL::to('lcms/delete_page/' . $page_id) }}' class='noajax confirm icon_delete_page'>Delete this page</a></li>
			@endif
			<li><a href='{{ URL::to('lcms/flush_all_caches') }}' class='noajax icon_flush_caches'>Flush all caches</a></li>
			<li><a href='#' class='noajax icon_flash_editables'>Flash editable areas</a></li>
			<li><a href='{{ URL::to('logout') }}' class='noajax icon_logout'>Log out</a></li>
		</ul>
	</nav>
	<div class='dyn_content'></div>
</div>
