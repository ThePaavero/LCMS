
<h1>User "{{ $data['user']['username'] }}"</h1>

<?php // echo '<pre>'; print_r($data['user']); echo '</pre>'; ?>

<div class='lcms_form_wrapper'>

	<form method='post' action='{{ URL::to('lcms/user_form') }}' id='lcms_user_form'>
		<input type='hidden' name='id' value='{{ $data['user']['id'] }}'/>
		<p><label>Username<input type='text' name='username' value='{{ $data['user']['username'] }}' /></label></p>
		<p><label>Email<input type='email' name='email' value='{{ $data['user']['email'] }}' /></label></p>
		<p><label>Password (leave empty for no change)<input type='password' name='password' value='' /></label></p>
		<p>
			<label>Role
				<select name='role'>
					@foreach($data['roles'] as $id => $name)
					<option value='{{ $id }}' @if($id == $data['user']['role']) selected @endif>{{ $name }}</option>
					@endforeach
				</select>
			</label>
		</p>
		<p><input type='submit' value='Ok'/></p>
	</form> <!-- lcms_user_form -->

</div><!-- lcms_form_wrapper -->
