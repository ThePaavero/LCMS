
<div class='lcms_modal'>

	<h1>Pages Index</h1>

	<h1>Create a new page</h1>

	<?php // echo '<pre>'; print_r($data); echo '</pre>'; ?>

	{{ Form::open(array('url' => 'lcms/create_page')) }}
		<p>
			<label>Template
				<select name='template'>
					@foreach($data['templates'] as $i)
					<option value='{{ $i['id'] }}'>{{ $i['description'] }}</option>
					@endforeach
				</select>
			</label>
		</p>
		<p><label>Title<input type='text' name='title'></label></p>
		<p><label>URL<input type='text' name='url'></label></p>
		<p>
			<input type='submit' value='Save'>
			<input type='hidden' name='parent_id' value='{{ $data['parent'] }}'>
		</p>
	{{ Form::close() }}

</div><!-- lcms_modal -->
