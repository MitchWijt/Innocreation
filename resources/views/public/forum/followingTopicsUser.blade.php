@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.forum_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.forum_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Topics i follow</h1>
            </div>
            @include("public.forum.shared._searchbarForum")
            <hr class="col-ms-12">
            <? if(count($followingTopicsUser) < 1) { ?>
                <div class="row">
                    <div class="col-sm-12 text-center m-t-20">
                        <p>You don't follow any topics yet. You can do that in the forum!</p>
                    </div>
                </div>
            <? } ?>
            <? foreach($followingTopicsUser as $followingTopicUser) { ?>
                <div class="row m-t-20">
                    <div class="card" >
                        <div class="card-block m-t-10">
                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-7">
                                        <a target="_blank" href="<?= $followingTopicUser->forumMainTopic->getUrl()?>" class="f-18 p-0 regular-link"><?=$followingTopicUser->forumMainTopic->title?></a>
                                    </div>
                                    <div class="col-sm-5">
                                        <p class="f-18 p-0 pull-right"><?=count($followingTopicUser->forumMainTopic->getNewThreads($followingTopicUser->seen_at))?> new threads</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection