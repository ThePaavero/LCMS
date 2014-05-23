
@if(empty($data['history']))
<p>No history for this block.</p>
@else
<h2>Previous versions of this block</h2>
<ul class='block_history_list' id='hl_{{ $data['instance_id'] }}'>
	@foreach($data['history'] as $i)
	<li>
		<a href='#{{ $i['id'] }}'>{{ $i['created_at'] }}</a>
	</li>
	@endforeach
</ul><!-- block_history_list -->

<script>
$(function()
{
	var block_id = {{ $data['block_id'] }};
	var historylist = new LCMS.Modules.HistoryList(block_id, $('#hl_{{ $data['instance_id'] }}'));
	historylist.init();
});
</script>
@endif

<?php // echo '<pre>'; print_r($data); echo '</pre>'; ?>