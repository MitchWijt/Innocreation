<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    {{--JS--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/jquery.easing.min.js"></script>
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>--}}
    {{--CSS--}}
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/css/activityTimeline.css">
    <link rel="stylesheet" href="/css/checkout/pricing.css">
    {{--CSS PLUGINS--}}
    <link rel="stylesheet" href="/assets/build/content-tools.min.css">
    <link rel="stylesheet" href="/css/bootstrap-tokenfield.css">
    <link rel="stylesheet" href="/css/jquery-ui-min.css">
    <link rel="stylesheet" href="/css/jquery.timepicker.css">
    {{------------------------}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    {{--JS PLUGINS--}}
        <script src="/assets/build/content-tools.js"></script>
        <script src="/assets/build/editor.js"></script>
        <script src="/js/bootstrap-tokenfield.min.js"></script>
        <script src="/js/jquery-ui.min.js"></script>
        <script defer src="/js/fontawesome-all.js"></script>
        <script defer src="/js/jquery.timepicker.min.js"></script>
        {{--ANIMATION--}}
            <script src="https://code.createjs.com/createjs-2015.11.26.min.js"></script>
            <script src="/assets/innocreation-animation.js"></script>
            <script src="/assets/animation.js"></script>
        {{--==============--}}
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=i4hrh8gzmh7fted3hqpgatcuwma8kl075x378rgkki09j852"></script>
    {{------------------------------}}
    <title>Innocreation</title>
</head>
<body>
@include('includes.header')
{{--@include('includes/flash')--}}
@yield('content')
@yield('pagescript')
@include('includes/footer')
</body>
</html>