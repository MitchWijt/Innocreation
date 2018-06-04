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
                <h1 class="sub-title-black @mobile f-20 @endmobile @tablet f-25 @endtablet"><?= $forumMainTopic->title?></h1>
            </div>
            <p class="text-center @mobile f-12 @endmobile @tablet f-12 @endtablet"><?= $forumMainTopic->description?></p>
            @include("public.forum.shared._searchbarForum")
            <hr class="col-ms-12">
            <div class="row">
                <div class="col-sm-12 d-flex">
                    <? if($user) { ?>
                        <div class="col-sm-6 p-0 m-t-5">
                            <? if(count($isFollowingTopic) < 1) { ?>
                                <form action="/forum/followMainTopic" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                                    <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                                    <button class="btn btn-inno">Follow this topic</button>
                                </form>
                            <? } else { ?>
                                <form action="/forum/unfollowMainTopic" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                                    <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                                    <button class="btn btn-inno">Unfollow topic</button>
                                </form>
                            <? } ?>
                        </div>
                        <div class="col-sm-6 p-0 m-t-5">
                            <button class="btn btn-inno pull-right" data-toggle="modal" data-target=".createThreadModal"> Create thread</button>
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
                                        <? if(count($threads->links()) > 1) { ?>
                                            <hr>
                                        <? } ?>
                                        <? foreach($threads as $thread) { ?>
                                            <div class="row">
                                                <div class="col-sm-12 m-l-15 d-flex">
                                                    <div class="col-sm-9">
                                                    <a href="/forum/<?= $thread->forumMainTopic->First()->slug?>/<?= $thread->id?>" class="c-gray"><p class="f-20 m-b-0"><?= $thread->title?></p></a>
                                                    <small class="c-dark-grey">Creator: <?= $thread->creator->getName()?>, <?= date("l d F Y", strtotime($thread->created_at))?> at <?= date("g:i:a", strtotime($thread->created_at))?></small>
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
    <? if($user) { ?>
        <div class="modal fade createThreadModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header col-sm-12 d-flex js-center">
                        <p class="m-t-10 f-18">Create new thread in <?= $forumMainTopic->title?></p>
                    </div>
                    <div class="modal-body ">
                        <form action="/forum/addNewThread" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                            <div class="row m-t-20">
                                <div class="col-sm-12">
                                    <input type="text" name="thread_title" class="input col-sm-5" placeholder="Thread title">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-sm-12 text-center">
                                    <textarea name="thread_message" placeholder="Thread message..." class="input col-sm-12 newThreadMessage" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-b-20 m-t-20">
                                    <button type="submit" class="btn btn-inno pull-right sendMessageReceivedAssistance">Create new thread</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
@endsection
@section('pagescript')
    <script src="/js/forum/forumMainTopicThreads.js"></script>
@endsection