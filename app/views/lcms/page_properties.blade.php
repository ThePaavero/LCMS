
<div class='lcms_modal page_properties'>

	<h1>Page Properties</h1>

<<<<<<< HEAD
	<div class='lcms_form_wrapper'>
=======
	<div class='lcms_page_form_wrapper'>
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		{{ Form::open(array('url' => 'lcms/update_page')) }}
		<input type ='hidden' name='page_id' value='{{ $data['page']['id'] }}'/>
			<p>
				<label>Template
					<select name='template'>
						@foreach($data['templates'] as $i)
						<option value='{{ $i['id'] }}'@if($i['id'] === $data['page']['template']) selected @endif>{{ $i['description'] }}</option>
						@endforeach
					</select>
				</label>
			</p>
			<p><label><span class ="label">Title</span><input type='text' name='title' value='{{ $data['page']['title'] }}'></label></p>
			<p><label><span class="label">URL</span><input type='text' name='url' value='{{ $data['page']['url'] }}'></label></p>
			<p><label><span class="label">Publish date</span><input type='text' name='published' class='datepicker' value='{{ $data['page']['published'] }}'></label></p>
			<p>
				<input type='submit' value='Save'>
				<input type='hidden' name='parent_id' value='{{ isset($data['parent']) ? $data['parent'] : 0 }}'>
			</p>
		{{ Form::close() }}
<<<<<<< HEAD
	</div><!-- lcms_form_wrapper -->
=======
	</div><!-- lcms_page_form_wrapper -->
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

</div><!-- lcms_modal -->

