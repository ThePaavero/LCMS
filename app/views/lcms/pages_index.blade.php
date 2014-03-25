
<div class='lcms_modal'>

	<h1>Pages Index</h1>

	<h1>Create a new page</h1>

	{{ Form::open(array('url' => 'lcms/create_page')) }}
		<p><label>Title<input type='text' name='title'></label></p>
		<p><label>URL<input type='text' name='url'></label></p>
		<p><label>Lang ID<input type='text' name='lang' value='1'></label></p>
		<p><input type='submit' value='Save'></p>
	{{ Form::close() }}

</div><!-- lcms_modal -->
