
<h1>Login</h1>

<form method='post' action='{{ URL::to('login') }}' id='login_form'>
	<p><label>Username<input type='text' name='username' /></label></p>
	<p><label>Password<input type='password' name='password' /></label></p>
	<p><input type='submit' value='Ok'/></p>
</form> <!-- login_form -->

<script>
$(function()
{
	$('#login_form input[name=username]').focus();
});
</script>