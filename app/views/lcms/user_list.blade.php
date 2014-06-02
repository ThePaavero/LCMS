
<h1>Users</h1>

<ul>
	@foreach($data['users'] as $user)
	<li>
		<a href='{{ URL::to('lcms/user_form/' . $user['id']) }}'>{{ $user['username'] }} ({{ $user['role_name'] }})</a>
	</li>
	@endforeach
</ul>
<?php // echo '<pre>'; print_r($data); echo '</pre>'; ?>