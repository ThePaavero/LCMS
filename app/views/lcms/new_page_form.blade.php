
<div class='lcms_modal create_new_page'>

	<h1>Pages Index</h1>

	@if (isset($data['parent_url']))
	<p>
		<h2>Create a new page under:</h2>
		<h3>{{ $data['parent_url'] }}</h3>
	</p>
	@else
		<h2>Create a new page</h2>
	@endif

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
		<p><label>URL segment<input type='text' name='url'></label></p>
		<p><label>Publish date<input type='text' name='published' class='datepicker'></label></p>
		<p>
			<input type='submit' value='Save'>
			<input type='hidden' name='parent_id' value='{{ isset($data['parent']) ? $data['parent'] : 0 }}'>
		</p>
	{{ Form::close() }}

</div><!-- lcms_modal -->
