
<h2>CMS</h2>

<nav>
	<ul>
		<li><a href='{{ URL::to('admin/users') }}' class='noajax'>Users</a></li>
		<li><a href='{{ URL::to('lcms/create_page/' . (isset($page_id) ? $page_id : 0)) }}'>Create new page here</a></li>
	</ul>
</nav>
