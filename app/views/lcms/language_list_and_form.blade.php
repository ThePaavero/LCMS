
<div class='lcms_modal language_list'>

	<h1>Languages</h1>
	<ul>
	@foreach($data['languages'] as $lang)
	    <li>
	        {{ $lang['name'] }} <small>({{ $lang['slug'] }})</small>
	        <a href='{{ URL::to('lcms/delete_language/' . $lang['id']) }}' class='delete_user confirm noajax'>×</a>
	    </li>
	@endforeach
	</ul>

	<div class='lcms_form_wrapper'>
	<h2>Create new language</h2>
		{{ Form::open(array('url' => 'lcms/create_language')) }}
		    <p>
		        <label>
		            Name
		            <input type='text' name='name' placeholder='Spanish'/>
		        </label>
		    </p>
		    <p>
                <label>
                    Slug
                    <input type='text' name='slug' placeholder='es'/>
                </label>
            </p>
            <p>
                <label>
                    Sort order
                    <input type='text' name='sort_order' placeholder='4'/>
                </label>
            </p>
			<p>
				<input type='submit' value='Save'>
			</p>
		{{ Form::close() }}
	</div><!-- lcms_form_wrapper -->

</div><!-- lcms_modal -->

