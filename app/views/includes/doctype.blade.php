<!doctype html>

<!--[if lt IE 7]> <html class='no-js ie6 oldie' lang='en'> <![endif]-->
<!--[if IE 7]>      <html class='no-js ie7 oldie' lang='en'> <![endif]-->
<!--[if IE 8]>      <html class='no-js ie8 oldie' lang='en'> <![endif]-->
<!--[if gt IE 8]><!--> <html class='no-js' lang='en'> <!--<![endif]-->

<head>

    <meta charset=UTF-8>

    <title>{{ (isset($title) ? (htmlspecialchars($title) . ' | ') : '') . htmlspecialchars(Config::get('app.site_name')) }}</title>

    <link rel='stylesheet' href='{{ URL::to('assets/css/project.min.css') }}'>
    {{-- <meta name='viewport' content='width=device-width,initial-scale=1'> --}}

    <!--[if lt IE 9]>
    <script src='{{ URL::to('/assets/js/system/html5.js') }}'></script>
    <![endif]-->

    <script>
    var _root = '{{ URL::to('') }}/';
    </script>

    <script src='//ajax.googleapis.com/ajax/libs/jquery/{{ Config::get('app.jquery_version') }}/jquery.min.js'></script>
    <script>window.jQuery || document.write('<script src="{{ URL::to('assets/js/lib/jquery-' . Config::get('app.jquery_version') . '.min.js') }}"><\/script>')</script>

    <script src='{{ URL::to('assets/js/autoloads.min.js') }}'></script>

    <script src='//tinymce.cachefly.net/4.0/tinymce.min.js'></script>
    <script src='{{ URL::to('assets/js/lcms.min.js') }}'></script>

    <meta name='lcms_page_id' value='{{ isset($data['page_id']) ? $data['page_id'] : '0' }}'/>

</head>