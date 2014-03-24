<div id='alerts'>
	@foreach(Alert::getMessages() as $type => $alerts)
		<div class='{{ $type }}'>
			@foreach($alerts as $alert)
				<div class='alert'>
					{{ $alert }}
				</div><!-- alert -->
			@endforeach
		</div><!-- {{ $type }} -->
	@endforeach
</div><!-- alerts -->