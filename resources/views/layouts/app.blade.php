<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="description" content="<? if(isset($og_description)) echo $og_description; else echo "Innocreation | The platform to connect,network,share and build with people active in various expertises on your innovative idea or project!"?>" />
    <meta name="google-site-verification" content="7i4l0CQ7KL5Rcffr4TDf0e7doWEObxrI-mRC_RXai2g" />
    <link rel="canonical" class="tweet-button-link" href="">
    <title><? if(isset($title)) echo $title  . " | "?>Innocreation</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-124028721-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-124028721-1');
    </script>

    {{--Meta TAGS--}}
    <meta name="google-site-verification" content="7i4l0CQ7KL5Rcffr4TDf0e7doWEObxrI-mRC_RXai2g" />
    {{--JS--}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
        {{--<script defer src="/js/popover.min.js"></script>--}}
        <script defer async src="/js/jquery.easing.min.js"></script>
        <script defer async src="/js/jquery.mobile.custom.js"></script>
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>--}}
    {{--CSS--}}

        <link  rel="stylesheet" href="/css/home/home.css" media="none" onload="if(media!=='all')media='all'">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/newStyle/style.css">
        <link rel="stylesheet" href="/css/general/modals.css">
        <link rel="stylesheet" href="/css/pages/aboutUs.css">
        <link rel="stylesheet" href="/css/pages/singleUserPage.css">
        <link rel="stylesheet" href="/css/header/style.css">
        <link rel="stylesheet" href="/css/footer/style.css">
        <link rel="stylesheet" href="/css/general.css">
        <link rel="stylesheet" href="/css/user/user.css">
        <link rel="stylesheet" href="/css/activityTimeline.css">
        <link rel="stylesheet" href="/css/checkout/pricing.css">
        <link rel="stylesheet" href="/css/checkout/selectPackage.css">
        <link rel="stylesheet" href="/css/registerProcess/index.css">
        <link rel="stylesheet" href="/css/userworkFeed/index.css">
        <link rel="stylesheet" href="/css/popovers.css">
        <link rel="stylesheet" href="/css/responsiveness/sidebar.css">
    {{--CSS MEDIA QUERIES--}}
        <link rel="stylesheet" href="/css/responsiveness/home.css">
    {{------------------------}}
    {{--CSS PLUGINS--}}
        <link rel="stylesheet" href="/assets/build/content-tools.min.css">
        <link rel="stylesheet" href="/css/bootstrap-tokenfield.css">
        <link rel="stylesheet" href="/css/jquery.timepicker.css">
        <link rel="stylesheet" href="/css/musicPlayer.css">
    {{------------------------}}
    {{--BOOTSTRAP SWITCH/TOGGLE--}}
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script defer async src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    {{--=========================--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    {{--JS PLUGINS--}}
        <script src="/js/assets/jquery-lazy.min.js"></script>
        <script src="/js/assets/lazyr.min.js"></script>
        <script src="/js/assets/bodyLockScroll.min.js"></script>
        <script defer async src="/assets/build/content-tools.js"></script>
        <script defer async src="/assets/build/editor.js"></script>
        <script src="/js/bootstrap-tokenfield.min.js"></script>
        <script defer async src="/js/fontawesome-all.js"></script>
        <script defer async src="/js/jquery.timepicker.min.js"></script>
        <script src="/js/floatingcarousel.min.js"></script>
        <script src="/js/jquery-ui.min.js"></script>
    {{--ANIMATION--}}
        <script defer async src="https://code.createjs.com/createjs-2015.11.26.min.js"></script>
        <script defer async src="/assets/innocreation-animation.js"></script>
        <script defer async src="/assets/animation.js"></script>
        <script defer async src="/js/assets/musicPlayer.js"></script>
        <script defer async src="/js/assets/videoPlayer.js"></script>

    {{--==============--}}
        <script defer async src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=i4hrh8gzmh7fted3hqpgatcuwma8kl075x378rgkki09j852"></script>
    {{------------------------------}}
    {{--FACEBOOK--}}
    <div id="fb-root"></div>
    {{--================--}}

    {{--RECAPTCHA--}}
        <script defer async src='https://www.google.com/recaptcha/api.js?hl=en'></script>
    {{--==============--}}
</head>
<body>
<div class="overlayContent <?= \App\Services\UserAccount\UserAccount::getTheme();?>">
<? if(\Illuminate\Support\Facades\Session::has("user_id")) {
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
    $userChats = \App\UserChat::select("*")->where("creator_user_id", $user->id)->orWhere("receiver_user_id", $user->id)->get();
    $counterMessages = 0;
    if(count($userChats) > 0){
        foreach($userChats as $userChat) {
            $unreadMessages = \App\UserMessage::select("*")->where("user_chat_id", $userChat->id)->where("sender_user_id", "!=", $user->id)->where("seen_at" ,null)->get();
            $counterMessages = $counterMessages + count($unreadMessages);
        }
    }
    $sessionUserId = \Illuminate\Support\Facades\Session::get("user_id");
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
} ?>
<? if(!isset($pageType) || $pageType != "clean") { ?>
    <? if(!isset($pageType) || $pageType != "checkout") { ?>
        @include('includes.header')
    <? } else { ?>
        @include('includes.headerCheckout')
    <? } ?>
<? } ?>
@yield('content')
@yield('pagescript')
<? if(!isset($pageType) || $pageType != "checkout") { ?>
    <? if(!isset($pageType) || ($pageType != "noFooter" && $pageType != "clean")) { ?>
        @include('includes/footer')
    <? } ?>
<? }
if(\Illuminate\Support\Facades\Session::has("user_id")){
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
    $user->online_timestamp = date("Y-m-d H:i:s");
    $user->active_status = "online";
    $user->save(); ?>
<? } ?>
<script src="/js/home/general.js"></script>
</div>
</body>
</html>