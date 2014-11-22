
<!-- Template "basic" starts -->

<<<<<<< HEAD
<?php // echo '<pre>'; print_r($data['components']); echo '</pre>'; ?>

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
<h1>{{ @$data['blocks']['Title']['contents'] }}</h1>

{{ @$data['blocks']['Body']['contents'] }}

<<<<<<< HEAD
@if(isset($data['components']['Teaser box']) && ! empty($data['components']['Teaser box']))
	@foreach($data['components']['Teaser box'] as $teaser_box)
	<div class='teaser_box'>
		{{ $teaser_box['admin_tools'] }}
		<h3>{{ @$teaser_box['Title']['contents'] }}</h3>
		<div>{{ @$teaser_box['Body']['contents'] }}</div>
	</div><!-- teaser_box -->
	@endforeach
@endif
{{ $CMS->getAddComponent('Teaser box') }}

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
<!-- Template "basic" ends -->
