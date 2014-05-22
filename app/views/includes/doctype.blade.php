<!doctype html>

<!--[if lt IE 7]> <html class='no-js ie6 oldie' lang='en'> <![endif]-->
<!--[if IE 7]>      <html class='no-js ie7 oldie' lang='en'> <![endif]-->
<!--[if IE 8]>      <html class='no-js ie8 oldie' lang='en'> <![endif]-->
<!--[if gt IE 8]><!--> <html class='no-js' lang='en'> <!--<![endif]-->

<head>

    <meta charset=UTF-8>

    <title>{{ (isset($title) ? (htmlspecialchars($title) . ' | ') : '') . htmlspecialchars(Config::get('app.site_name')) }}</title>

    <link rel='stylesheet' href='{{ URL::to('assets/css/project.css') }}'>
    {{-- <meta name='viewport' content='width=device-width,initial-scale=1'> --}}

    <!--[if lt IE 9]>
    <script src='{{ URL::to('/assets/js/system/html5.js') }}'></script>
    <![endif]-->

    <script>
        var _root = "{{ URL::to('') }}/";
    </script>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
    <script src="{{ URL::to('assets/js/project.min.js') }}"></script>

    @include('lcms.asset_includes')

    <meta name='lcms_page_id' value="{{ isset($data['page_id']) ? $data['page_id'] : '0' }}"/>

</head>
