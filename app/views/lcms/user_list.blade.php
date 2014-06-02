
<h1>Users</h1>

<ul>
	@foreach($data['users'] as $user)
	<li>
		<a href='{{ URL::to('lcms/user_form/' . $user['id']) }}'>{{ $user['username'] }} ({{ $user['role_name'] }})</a>
		<a href='{{ URL::to('lcms/delete_user/' . $user['id']) }}' class='delete_user confirm'>×</a>
	</li>
	@endforeach
</ul>
<?php // echo '<pre>'; print_r($data); echo '</pre>'; ?>

<p class='lcms_modal_note'>
	NOTE: To create new users, use artisan.
</p><!-- lcms_modal_note -->
