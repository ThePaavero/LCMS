
<footer id='common_footer'>

	{{ $CMS->block(2) }}

	@if(isset(Auth::user()->username))
	<p>
		You're logged in as "{{ Auth::user()->username }}" | <a href='{{ URL::to('logout') }}'>Logout</a>
	</p>
	@endif

</footer><!-- common_footer -->
