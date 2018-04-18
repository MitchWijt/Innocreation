@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.forum_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Forums</h1>
            </div>
            <hr class="col-ms-12">
            <? foreach($forumMainTopicTypes as $forumMainTopicType) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20"><?= $forumMainTopicType->title?></p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <? foreach($forumMainTopicType->getMainTopics() as $forumMainTopic) { ?>
                                <div class="row">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-9">
                                            <a href="/forum/topic/<?= $forumMainTopic->id?>" class="c-gray">
                                                <p class="f-21 m-b-5"><?= $forumMainTopic->title?><i class="zmdi zmdi-comment-outline m-l-10 f-17 c-orange"></i></p>
                                            </a>
                                            <p class="col-sm-10 p-0 f-13"><?= $forumMainTopic->description?></p>
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="f-21 m-t-10 pull-right">Posts: <?= count($forumMainTopic->getAmountPosts())?></p>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <? } ?>
        </div>
    </div>
@endsection