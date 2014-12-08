
<div class='lcms_component_add_new'>
	<a href='{{ URL::to('lcms/add_new_component/' . $component_type_id . '/[LCMS_PAGE_ID]') }}'>Add new {{ $component_type_name }}</a>

	@if( ! empty($componentItems))
	<div class='choose-existing-component-wrapper'>
	    <p>
            ...or choose an existing one:
	    </p>
        <form method='post' action='#' class='lcms-admin-select-component-form'>
            <select name='component_id'>
                @foreach($componentItems as $item)
                {{ var_dump($item) }}
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <p><input type='submit' value='Add chosen'/></p>
        </form> <!-- lcms-admin-select-component-form -->
	</div><!-- choose-existing-component-wrapper -->
	@endif

</div><!-- lcms_component_add_new -->
