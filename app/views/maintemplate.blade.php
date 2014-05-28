@include("includes.doctype")

<body class='{{ Request::segment(1) }}'>

	@include("includes.alerts")

    <div id='lcms_container'>

        <div class='cms_navigation'>
            {{ $CMS->sitemapAsNavigation(false) }}
        </div><!-- cms_navigation -->

		@include("includes.header")

        <div id='page_content'>

			@include($page)

        </div>

		@include("includes.footer")

    </div> <!-- lcms_container -->
</body>
</html>
