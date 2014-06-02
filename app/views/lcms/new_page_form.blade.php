
<div class='lcms_modal create_new_page'>

	<h1>Create New Page</h1>

	@if (isset($data['parent_url']))
	<h2>Create a new page under "{{ $data['parent_url'] }}"</h2>
	@else
	<h2>Create a new page</h2>
	@endif

	<div class='lcms_form_wrapper'>
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
			<p><label><span class="label">Title</span><input type='text' name='title'></label></p>
			<p><label><span class="label">URL</span><input type='text' name='url' value='{{ isset($data['parent_url']) ? $data['parent_url'] . '/' : ''}}'></label></p>
			<p><label><span class="label">Publish date</span><input type='text' name='published' class='datepicker' value='{{ $data['published'] }}'></label></p>
			<p>
				<input type='submit' value='Save'>
				<input type='hidden' name='parent_id' value='{{ isset($data['parent']) ? $data['parent'] : 0 }}'>
			</p>
		{{ Form::close() }}
	</div><!-- lcms_form_wrapper -->

</div><!-- lcms_modal -->

