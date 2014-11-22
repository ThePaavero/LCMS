@include("includes.doctype")

<body class='{{ Request::segment(1) }}'>

	@include("includes.alerts")

    <div id='lcms_container'>

<<<<<<< HEAD
=======
        <div class='cms_navigation'>
            {{ $CMS->sitemapAsNavigation(false) }}
        </div><!-- cms_navigation -->

>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		@include("includes.header")

        <div id='page_content'>

			@include($page)

        </div>

		@include("includes.footer")

    </div> <!-- lcms_container -->
</body>
</html>
