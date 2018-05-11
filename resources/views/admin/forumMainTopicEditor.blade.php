@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 <? if(isset($forumMainTopic)) echo "d-flex js-between"?>">
                                <h4 class="m-t-5"><? if(isset($forumMainTopic)) echo $forumMainTopic->title; else echo "Create new topic"?></h4>
                                <? if(isset($forumMainTopic)) { ?>
                                    <div class="buttons m-t-5 m-b-10 d-flex">
                                        <form action="/admin/deleteForumMainTopic" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                                            <button class="btn btn-inno btn-sm m-r-5">Delete <i class="zmdi zmdi-delete"></i></button>
                                        </form>
                                        <? if($forumMainTopic->published == 1) { ?>
                                            <form action="/admin/hideForumMainTopic" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                                                <button class="btn btn-inno btn-sm">Hide <i class="zmdi zmdi-eye-off"></i></button>
                                            </form>
                                        <? } else { ?>
                                            <form action="/admin/publishForumMainTopic" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                                                <button class="btn btn-inno btn-sm">Publish <i class="zmdi zmdi-eye"></i></button>
                                            </form>
                                        <? } ?>
                                    </div>
                                <? } ?>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-b-20">
                                <form action="/admin/saveForumMainTopic" method="post" class="m-t-20">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <? if(isset($forumMainTopic)) { ?>
                                        <input type="hidden" name="forum_main_topic_id" value="<?= $forumMainTopic->id?>">
                                    <? } ?>
                                    <div class="col-sm-12">
                                        <p class="m-b-5 f-13">Title</p>
                                        <input type="text" name="title" class="input col-sm-4" value="<? if(isset($forumMainTopic)) echo $forumMainTopic->title?>">
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <p class="m-b-5 f-13">Category</p>
                                    </div>
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-4 p-0">
                                            <select name="forumMainTopicType" class="input col-sm-11 m-0 p-0">
                                                <? foreach($forumMainTopicTypes as $forumMainTopicType) { ?>
                                                    <option <? if(isset($forumMainTopic) && $forumMainTopic->main_topic_type_id == $forumMainTopicType->id) echo "selected"?> value="<?= $forumMainTopicType->id?>"><?= $forumMainTopicType->title?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 p-0">
                                            <p class="text-center">Or</p>
                                        </div>
                                        <div class="col-sm-4 p-0">
                                            <input type="text" name="newForumMainTopicType" class="input col-sm-11" placeholder="New category">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <textarea name="description" class="col-sm-12 input" cols="30" rows="10"><? if(isset($forumMainTopic)) echo $forumMainTopic->description?></textarea>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <button class="btn btn-inno pull-right">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection