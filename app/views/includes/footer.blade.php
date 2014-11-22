
<footer id='common_footer'>

<<<<<<< HEAD
	{{ $CMS->block(2) }}
=======
	{{ $CMS->block(6) }}

	@if(isset(Auth::user()->username))
	<p>
		You're logged in as "{{ Auth::user()->username }}" | <a href='{{ URL::to('logout') }}'>Logout</a>
	</p>
	@endif
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

</footer><!-- common_footer -->
