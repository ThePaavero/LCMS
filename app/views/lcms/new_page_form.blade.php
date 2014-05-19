
<div class='lcms_modal'>

	<h1>Pages Index</h1>

	<h1>Create a new page</h1>

	<?php echo '<pre>'; print_r($data); echo '</pre>'; ?>

	{{ Form::open(array('url' => 'lcms/create_page')) }}
		<p><label>Template<input type='text' name='template' value='1'></label></p>
		<p><label>Title<input type='text' name='title'></label></p>
		<p><label>URL<input type='text' name='url'></label></p>
		<p><input type='submit' value='Save'></p>
	{{ Form::close() }}

</div><!-- lcms_modal -->
