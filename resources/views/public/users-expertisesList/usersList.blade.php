@extends("layouts.app")
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="d-flex grey-background vh85">
            <div class="container">
                <div class="sub-title-container p-t-20">
                    <h1 class="sub-title-black bold @mobile f-20 @endmobile">All users active in <?= $expertise->title?></h1>
                </div>
                <hr style="margin-bottom: 100px !important;">
                <div class="row">
                <? foreach($expertise->getActiveUsers() as $user) { ?>

                        <div class="col-xl-4 m-t-10">
                            <div class="card userCard m-t-20 m-b-20">
                                <div class="card-block p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                    <a href="<?= $user->getUrl()?>">
                                        <div class="overlay-expertise-user"></div>
                                    </a>
                                    <a class="userCardContent" href="<?= $user->getUrl()?>">
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 39%; left: 50%; transform: translate(-50%, -50%)">
                                            <div class="avatar" style="background: url('<?= $user->getProfilePicture()?>'); z-index: 2000000; opacity: 1 !important"></div>
                                        </div>
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 66%; left: 50%; transform: translate(-50%, -50%)">
                                            <p class="c-white f-16"><?= $user->getName()?></p>
                                        </div>
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 77%; left: 50%; transform: translate(-50%, -50%)">
                                            <p class="c-orange f-11">@<?= $user->slug?></p>
                                        </div>
                                        <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 98%; left: 50%; transform: translate(-50%, -50%)">
                                            <button class="btn btn-inno-cta btn-sm">More info</button>
                                        </div>
                                    </a>
                                    <a href="<?= $user->getUrl()?>" style="z-index: 400;">
                                        <div class="userCardContent lazyLoad" data-src="<?= $user->getBanner()?>"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                <? } ?>
                </div>
                </div>
            </div>
        </div>
@endsection
@section('pagescript')
    <script src="/js/usersList/usersList.js"></script>
    <script defer async src="/js/lazyLoader.js"></script>
@endsection