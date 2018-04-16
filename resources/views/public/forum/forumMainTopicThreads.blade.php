@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.forum_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $forumMainTopic->title?></h1>
            </div>
            <p class="text-center"><?= $forumMainTopic->description?></p>
            <hr class="col-ms-12">
            <div class="row">
                <div class="col-sm-12 d-flex">
                    <? if($user) { ?>
                        <div class="col-sm-6 p-0 m-t-5">
                            <button class="btn btn-inno">Follow this topic</button>
                        </div>
                        <div class="col-sm-6 p-0 m-t-5">
                            <button class="btn btn-inno pull-right"> Create thread</button>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <?= $threads->links()?>
                                        <hr>
                                        <? foreach($threads as $thread) { ?>
                                            <div class="row">
                                                <div class="col-sm-12 m-l-15 d-flex">
                                                    <div class="col-sm-9">
                                                    <p class="f-22 m-b-0"><?= $thread->title?></p>
                                                    <small class="c-dark-grey">Creator: <?= $thread->creator->getName()?>, <?= date("l d F Y")?> at <?= date("g:i:a")?></small>
                                                    <? if($thread->creator->team_id != null) { ?>
                                                        <p><small class="c-dark-grey">Team: <?= $thread->creator->team->team_name?></small></p>
                                                    <? } ?>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="pull-right m-r-15 m-t-10">
                                                        <p><?= count($thread->getReplies())?> replies</p>
                                                        <p><?= $thread->views?> views</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/forum/forumMainTopicThreads.js"></script>
@endsection