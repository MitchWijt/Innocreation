@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.forum_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Search results</h1>
            </div>
            @include("public.forum.shared._searchbarForum")
            <hr class="col-ms-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20">Threads</p>
                                        <hr class="hr">
                                    </div>
                                </div>
                            </div>
                            <? if(isset($forumThreadResults) && count($forumThreadResults) > 0) { ?>
                                <? foreach($forumThreadResults as $forumThreadResult) { ?>
                                    <div class="row">
                                        <div class=" d-flex">
                                            <div class="col-sm-12">
                                                <a href="<?= $forumThreadResult->getUrl()?>" class="regular-link">
                                                    <p class="f-21 m-b-5 col-sm-12"><?= $forumThreadResult->title?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } else { ?>
                                <p class="col-sm-12 c-dark-grey"><i>No search results</i></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20">Main topics</p>
                                        <hr class="hr">
                                    </div>
                                </div>
                            </div>
                            <? if(isset($forumMainTopicResults) && count($forumMainTopicResults) > 0) { ?>
                                <? foreach($forumMainTopicResults as $forumMainTopicResult) { ?>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex">
                                            <div class="">
                                                <a href="<?= $forumMainTopicResult->getUrl()?>" class="regular-link">
                                                    <p class="f-21 m-b-5 col-sm-12"><?= $forumMainTopicResult->title?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } else { ?>
                                <p class="col-sm-12 c-dark-grey"><i>No search results</i></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20">Thread comments</p>
                                        <hr class="hr">
                                    </div>
                                </div>
                            </div>
                            <? if(isset($forumThreadCommentResults) && count($forumThreadCommentResults) > 0) { ?>
                                <? foreach($forumThreadCommentResults as $forumThreadCommentResult) { ?>
                                    <div class="row">
                                        <div class=" d-flex">
                                            <div class="col-sm-12">
                                                <a href="<?= $forumThreadCommentResult->thread->First()->getUrl()?>" class="regular-link">
                                                    <p class="f-21 m-b-5 col-sm-12"><?= $forumThreadCommentResult->message?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } else { ?>
                                <p class="col-sm-12 c-dark-grey"><i>No search results</i></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection