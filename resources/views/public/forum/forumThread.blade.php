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
                <h1 class="sub-title-black"><?= $forumThread->title?></h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <small class="c-dark-grey">Creator: <a href="<?= $forumThread->creator->getUrl()?>" class="c-dark-grey" target="_blank"><?= $forumThread->creator->getName()?></a>, <?= date("l d F Y", strtotime($forumThread->created_at))?> at <?= date("g:i:a", strtotime($forumThread->created_at))?>. In <?= $forumMainTopic->title?></small>
                </div>
            </div>
            @include("public.forum.shared._searchbarForum")
            <hr class="col-ms-12">
            @if(session('success'))
                <div class="alert alert-success m-b-20 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <? if($loggedIn) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="/forum/shareThreadWithTeam" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?=$user->id?>">
                            <input type="hidden" name="thread_id" value="<?=$forumThread->id?>">
                            <input type="hidden" name="thread_link" value="http://<?=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>">
                            <button class="btn btn-inno pull-right btn-sm m-t-10">Share thread with team chat</button>
                        </form>
                    </div>
                </div>
            <? } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-10 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <div class="row">
                                            <div class="col-sm-12 d-flex">
                                                <div class="col-sm-2 m-r-0 text-center">
                                                    <img class="circleImage circle m-r-0" src="<?= $forumThread->creator->getProfilePicture()?>" alt="<?= $forumThread->title?>">
                                                    <a href="<?= $forumThread->creator->getUrl()?>" class="regular-link" target="_blank"><p class="m-b-0 m-t-5"><?= $forumThread->creator->getName()?></p></a>
                                                    <p class="m-b-5"><?= count($forumThread->creator->getAmountThreadPosts())?> posts</p>
                                                </div>
                                                <div class="col-sm-8 m-r-0 text-center m-t-25">
                                                    <p class="m-b-0 m-t-5"><i class="zmdi zmdi-star c-orange"></i> Thread creator</p>
                                                    <p>Team: <a target="_blank" href="/team/<?= ucfirst($forumThread->creator->team->team_name)?>" class="regular-link"><?= $forumThread->creator->team->team_name?></a></p>
                                                </div>
                                                <div class="col-sm-2 m-r-0 text-center m-t-25">
                                                    <? foreach($forumThread->creator->getExpertises() as $expertise) { ?>
                                                        <p class="m-b-5"><?= $expertise->title?></p>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12 m-t-10">
                                                <p class="col-sm-12"><?= $forumThread->message?></p>
                                                <?
                                                $today = new DateTime(date("Y-m-d g:i a"));
                                                $postedTime = new DateTime(date("Y-m-d g:i a",strtotime($forumThread->created_at)));
                                                $interval = $today->diff($postedTime);
                                                ?>
                                                <small class="m-l-10 c-dark-grey pull-right m-r-20 m-b-10">Posted <?= $interval->format("%d days, " . '%h hours, ' . "%i minutes");?> ago</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <? if(count($allForumThreadComments) > 10) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex js-center">
                            <div class="card card-lg m-t-20 col-sm-12">
                                <div class="card-block m-t-10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $forumThreadComments->links()?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <? foreach($forumThreadComments as $threadComment) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-11">
                        <div class="card card-lg m-t-10 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <div class="row">
                                            <div class="col-sm-12 d-flex">
                                                <div class="col-sm-2 m-r-0 text-center">
                                                    <img class="circleImage circle m-r-0" src="<?= $threadComment->creator->getProfilePicture()?>" alt="<?= $forumThread->title?>">
                                                    <a href="<?= $threadComment->creator->getUrl()?>" class="regular-link" target="_blank"><p class="m-b-0 m-t-5"><?= $threadComment->creator->getName()?></p></a>
                                                    <p class="m-b-5"><?= count($threadComment->creator->getAmountThreadPosts())?> posts</p>
                                                </div>
                                                <div class="col-sm-8 m-r-0 text-center m-t-25">
                                                    <? if($threadComment->creator_user_id == $forumThread->creator_user_id) { ?>
                                                        <p class="m-b-0 m-t-5"><i class="zmdi zmdi-star c-orange"></i> Thread creator</p>
                                                    <? } ?>
                                                    <p>Team: <a target="_blank" href="/team/<?= ucfirst($threadComment->creator->team->team_name)?>" class="regular-link"><?= $threadComment->creator->team->team_name?></a></p>
                                                </div>
                                                <div class="col-sm-2 m-r-0 text-center m-t-25">
                                                    <? foreach($threadComment->creator->getExpertises() as $expertise) { ?>
                                                    <p class="m-b-5"><?= $expertise->title?></p>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12 m-t-10">
                                                <p class="col-sm-12"><?= $threadComment->message?></p>
                                                <?
                                                $today = new DateTime(date("Y-m-d g:i a"));
                                                $postedTime = new DateTime(date("Y-m-d g:i a",strtotime($threadComment->created_at)));
                                                $interval = $today->diff($postedTime);
                                                ?>
                                                <small class="m-l-10 c-dark-grey pull-right m-r-20 m-b-10">Posted <?= $interval->format("%d days, " . '%h hours, ' . "%i minutes");?> ago</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <? if(count($allForumThreadComments) > 10) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex js-center">
                            <div class="card card-lg m-b-20 col-sm-12">
                                <div class="card-block m-t-10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $forumThreadComments->links()?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <? if($loggedIn) { ?>
            <div class="row">
                <div class="col-sm-12 m-t-20">
                    <form action="/forum/postThreadComment" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?=$user->id?>">
                        <input type="hidden" name="thread_id" value="<?=$forumThread->id?>">
                        <textarea placeholder="Write your thread comment here..." name="forumThreadComment" class="forumThreadComment input col-sm-12"  cols="30" rows="10"></textarea>
                        <button class="btn btn-inno pull-right m-t-10 m-b-20">Post comment</button>
                    </form>
                </div>
            </div>
            <? } else { ?>
                <div class="row">
                    <div class="col-sm-12 m-t-10 m-b-10">
                        <p class="f-20 text-center"><a class="regular-link" href="/login">Create an account</a> or <a class="regular-link" href="/login">login</a> to take part!</p>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/forum/forumThread.js"></script>
@endsection