<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    {{--JS--}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        {{--<script defer src="/js/popover.min.js"></script>--}}
        <script src="/js/jquery.easing.min.js"></script>
        <script src="/js/home/accountHelper.js"></script>
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>--}}
    {{--CSS--}}
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/activityTimeline.css">
        <link rel="stylesheet" href="/css/checkout/pricing.css">
        <link rel="stylesheet" href="/css/checkout/selectPackage.css">
    {{--CSS PLUGINS--}}
        <link rel="stylesheet" href="/assets/build/content-tools.min.css">
        <link rel="stylesheet" href="/css/bootstrap-tokenfield.css">
        <link rel="stylesheet" href="/css/jquery-ui-min.css">
        <link rel="stylesheet" href="/css/jquery.timepicker.css">
    {{------------------------}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>--}}
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
    {{--FACEBOOK--}}
    <div id="fb-root"></div>
    {{--================--}}

    {{--RECAPTCHA--}}
        <script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
    {{--==============--}}

    <script></script>

    <meta name="description" content="<? if(isset($og_description)) echo $og_description?>" />
    <meta name="google-site-verification" content="7i4l0CQ7KL5Rcffr4TDf0e7doWEObxrI-mRC_RXai2g" />
    <link rel="canonical" class="tweet-button-link" href="">
    <title><? if(isset($title)) echo $title ?> | Innocreation</title>
</head>
<body>
<? if(\Illuminate\Support\Facades\Session::has("user_id")) {
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
} ?>
<? if(!isset($pageType) || $pageType != "checkout") { ?>
@mobile
    <? if(\Illuminate\Support\Facades\Session::has("user_id") && $user->finished_helper == 0) {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
    <? if(strpos($url, "/account") || strpos($url, "/my-account/expertises") || strpos($url, "/my-account/portfolio")  || strpos($url, "/my-team")) {  ?>
        <? if(strpos($url, "/account") != false || strpos($url, "/my-team") != false || strpos($url, "/my-account") != false)  { ?>
            <div style="position: fixed; z-index: 99 !important" class="accountHelper">
                @include('includes.accountHelper')
            </div>
        <? } ?>
    <? } ?>
<? } ?>
@endmobile
    @include('includes.header')
<? } else { ?>
    @include('includes.headerCheckout')
<? } ?>
{{--@include('includes/flash')--}}
@notmobile
    <? if(\Illuminate\Support\Facades\Session::has("user_id") && $user->finished_helper == 0) {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
            <? if(strpos($url, "/account") || strpos($url, "/my-account/expertises") || strpos($url, "/my-account/portfolio")  || strpos($url, "/my-team")) {  ?>
                <? if(strpos($url, "/account") != false || strpos($url, "/my-team") != false || strpos($url, "/my-account") != false)  { ?>
                    <div style="position: fixed; z-index: 99 !important" class="accountHelper">
                        @include('includes.accountHelper')
                    </div>
                <? } ?>
            <? } ?>
    <? } ?>
@endnotmobile
@yield('content')
@yield('pagescript')
<? if(!isset($pageType) || $pageType != "checkout") { ?>
    @include('includes/footer')
<? } ?>

</body>
</html>