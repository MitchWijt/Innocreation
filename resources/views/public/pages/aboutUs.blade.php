@extends('layouts.app')
@section('content')
<div class="<?= \App\Services\UserAccount\UserAccount::getTheme();?>">
    <div class="grey-background vh85 o-hidden">
        <div class="container <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
            <div class="row" style="margin-bottom: 230px">
                <div class="col-sm-12 text-center" style="margin-top: 130px;">
                    <h1 class="f-50 bold">Collaborate on awesome projects.</h1>
                    <p class="f-20 m-b-5">Collaborate and connect with creatives</p>
                    <p class="f-20">active in <span class="bold"><?= $amountExpertises?></span> different and innovative expertises</p>
                    <a href="/create-my-account" class="btn btn-inno-cta p-t-15 p-b-15 p-l-10 p-r-10 m-t-40">Join the creative community for free</a>
                </div>
            </div>
        </div>
        <div class="bannerImage"></div>
        <div class="row" style="margin-bottom: 120px; margin-top: 120px;">
            <div class="col-sm-12 text-center">
                <h1 class="f-50 bold">What can Innocreation do for me?</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row d-flex" style="margin-bottom: 220px;">
                <div class="col-sm-7">
                    <div class="col-sm-8" style="margin-left: 80px;">
                        <p class="f-31 bold">Put together or join that team that you were searching for so long!</p>
                        <p class="m-t-5 m-b-0">Been searching for that team of creative people
                            to help you on your project? Find them here on Innocreation.
                            Build a connection, Create a team and start planning.</p>
                        <p>Rather help others than creating a team? No worries!
                            Join as your creative expertise and send a request out to
                            help other teams with your expertise!</p>
                        <a href="/teams" class="btn btn-inno-cta p-t-15 p-b-15 p-l-10 p-r-10 m-t-10">Discover the creative teams</a>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="image2"></div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-12 text-center">
                <p class="f-31 bold">Collaborate and connect with other creative people.</p>
                <p>Make connections and get to know the amazing creative community. They might be the next step of your amazing project!</p>
                <a href="/expertises" class="btn btn-inno-cta p-t-15 p-b-15 p-l-10 p-r-10 m-t-10">Connect with the creatives</a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row" style="margin-bottom: 220px;">
                <? foreach($expertiseLinktables as $linktable) { ?>
                    <div class="col-sm-4 m-t-10">
                        <div class="card userCard m-t-20 m-b-20">
                            <div class="card-block p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                    <a class="c-gray f-9 photographer" target="_blank" href="<?= $linktable->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $linktable->photographer_link?>"><?= $linktable->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                </div>
                                <? if($linktable->users->First()) { ?>
                                    <a href="<?= $linktable->users->First()->getUrl()?>">
                                        <div class="overlay-expertise-user"></div>
                                    </a>
                                    <a class="userCardContent" href="<?= $linktable->users->First()->getUrl()?>">
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 39%; left: 50%; transform: translate(-50%, -50%)">
                                            <div class="avatar" style="background: url('<?= $linktable->users->First()->getProfilePicture()?>'); z-index: 2000000; opacity: 1 !important"></div>
                                        </div>
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 66%; left: 50%; transform: translate(-50%, -50%)">
                                            <p class="c-white f-16"><?= $linktable->users->First()->getName()?></p>
                                        </div>
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 77%; left: 50%; transform: translate(-50%, -50%)">
                                            <p class="c-orange f-11">@<?= $linktable->users->First()->slug?></p>
                                        </div>
                                    </a>
                                    <a href="<?= $linktable->users->First()->getUrl()?>" style="z-index: 400;">
                                        <div class="userCardContent lazyLoad" data-src="<?= $linktable->image?>"></div>
                                    </a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
        <div class="row d-flex" style="margin-bottom: 390px;">
            <div class="col-sm-5 m-t-25" style="margin-left: 120px;">
                <div class="image_feed"></div>
            </div>
            <div class="col-sm-6 d-flex jc-end">
                <div class="col-sm-8" style="margin-right: 80px;">
                    <p class="f-31 bold">Share your passion. Help others with your passion.</p>
                    <p class="m-t-5 m-b-0">Share your passion on the creatives feed. Let others
                        see why you are good at what you do so they can
                        make a connection with you.</p>
                    <p>Help other with your passion. Give feedback on other
                        posts to help each other out and build your network!</p>
                    <a href="/innocreatives" class="btn btn-inno-cta p-t-15 p-b-15 p-l-10 p-r-10 m-t-10">Share your creative work</a>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 220px;">
            <div class="col-sm-12 text-center">
                <h1 class="f-50 bold m-b-20">Have fun and share your creative passion!</h1>
                <a href="/create-my-account" class="btn btn-inno-cta p-t-15 p-b-15 p-l-10 p-r-10 m-t-10">Lets start building awesome projects</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pagescript')
    <script defer async src="/js/lazyLoader.js"></script>
@endsection
