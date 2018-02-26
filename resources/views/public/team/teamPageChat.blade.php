@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team chat</h1>
            </div>
            <hr class="col-ms-12">
            <div class="row d-flex js-center ">
                <? if($user->id == $team->ceo_user_id || $user->role == 1) { ?>
                    <div class="col-sm-11 p-r-0 m-t-15">
                        <button class="btn btn-inno pull-right" data-toggle="modal" data-target="#createGroupChat">Create group chat</button>
                    </div>
                <? } ?>
                <div class="card col-sm-11 m-t-20 m-b-20">
                    <div class="card-block">
                        <div class="row text-center">
                            <div class="col-sm-12 m-t-20 m-b-20 d-flex">
                                <div class="col-sm-4">
                                    <img class="circleImage circle" src="<?= $team->getProfilePicture()?>" alt="<?= $team->team_name?>">
                                </div>
                                <div class="col-sm-4">
                                    <h3><?= $team->team_name?></h3>
                                    <p class="c-orange"><?= count($team->getMembers())?> members</p>
                                </div>
                                <div class="col-sm-4 m-t-10">
                                    <a href="/team/<?=$team->team_name?>" class="btn btn-inno livePage">Go to live page</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex js-center">
                            <hr class="col-sm-12 m-b-20">
                        </div>
                        <div class="o-scroll m-t-20" style="height: 400px;">
                            <? foreach($messages as $message) { ?>
                                <? if($message->sender_user_id == $user->id) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-5 messageSent pull-right m-b-10">
                                            <p><?= $message->message?></p>
                                            <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                        </div>
                                    </div>
                                </div>
                                <? } else { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                            <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                                            <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - CEO:</p>
                                            <? } else { ?>
                                            <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - <?= $message->sender->First()->getJoinedExpertise()->expertises->First()->title?>:</p>
                                            <? } ?>
                                            <p><?= $message->message?></p>
                                            <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                        </div>
                                    </div>
                                </div>
                                <? } ?>
                            <? } ?>
                        </div>
                        <div class="d-flex js-center">
                            <hr class="col-sm-12 m-b-20">
                        </div>
                        <? if($user->muted <= date("Y-m-d H:i:s")) { ?>
                        <form action="/my-team/sendTeamMessage" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="team_id" value="<?=$team->id?>">
                            <input type="hidden" name="sender_user_id" value="<?=$user->id?>">

                            <div class="row m-t-20">
                                <div class="col-sm-12 text-center">
                                    <textarea name="teamMessage" placeholder="Send your message..." class="input col-sm-10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-11 m-b-20 m-t-20">
                                    <button class="btn btn-inno pull-right">Send message</button>
                                </div>
                            </div>
                        </form>
                        <? } else { ?>
                        <?
                        $today = new DateTime(date("Y-m-d H:i:s"));
                        $date = new DateTime(date("Y-m-d H:i:s",strtotime($user->muted)));
                        $interval = $date->diff($today);
                        ?>
                        <div class="row m-t-20 m-b-10">
                            <div class="col-sm-12 text-center">
                                <p>You have been muted for <?= $interval->format('%h hours, %i minutes, %s seconds');?></p>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                </div>
            </div>


            {{--GROUP CHAT PLACE AND CODE--}}
            <div class="m-b-20">
                <? foreach($groupChats as $groupChat) { ?>
                    <div class="groupChat">
                        <div class="d-flex fd-column m-t-20">
                            <div class="row d-flex js-center">
                                <div class="card-lg text-center col-sm-11" style="height: 90px;">
                                    <div class="co-sm-12 d-flex">
                                        <div class="col-sm-4">

                                            <? if($groupChat->groupChat->First()->profile_picture == null) { ?>
                                                <? if($user->id == $team->ceo_user_id || $user->role == 1) { ?>
                                                    <form action="/my-team/uploadProfilePictureTeamGroupChat" class="groupChatProfilePicForm" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="group_chat_id" value="<?= $groupChat->team_chat_group_id?>">
                                                        <input type="file" class="hidden profilePictureGroupChat" name="profile_picture_group_chat">
                                                        <button type="button" class="btn btn-inno m-t-20 uploadProfilePic">Upload picture</button>
                                                    </form>
                                                <? } ?>
                                            <? } else { ?>
                                                <img class="circleImage circle m-t-10" src="<?= $groupChat->groupChat->First()->getProfilePicture()?>" alt="<?= $groupChat->groupChat->First()->title?>">
                                            <? } ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card-block groupChatCardToggle d-flex js-around m-t-10" data-group-chat-id="<?= $groupChat->team_chat_group_id?>">
                                                <p class="f-22 m-t-15 m-b-5 p-0"><?= $groupChat->groupChat->First()->title?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 m-t-20">
                                            <? if($user->id == $team->ceo_user_id || $user->role == 1) { ?>
                                                <button class="btn btn-inno settingsGroupChatBtn">Settings</button>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse collapseExample groupChatCollapse" id="groupChat" data-group-chat-id="<?= $groupChat->team_chat_group_id?>">
                                <div class="row d-flex js-center">
                                    <div class="card-lg card-block col-sm-11 m-b-20">
                                        <form action="/my-team/sendMessageTeamGroupChat" method="post">
                                            <? if(isset($urlParameter)) { ?>
                                            <input type="hidden" name="url_content" class="url_content" value="<?= $urlParameter?>">
                                            <? } ?>
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="sender_user_id" value="<?= $user->id?>">
                                            <input type="hidden" name="chat_group_id" value="<?= $groupChat->team_chat_group_id?>">
                                            <div class="o-scroll m-t-20" style="height: 300px;">
                                                <? foreach($groupChat->getGroupChatMessages() as $message) { ?>
                                                    <? if($message->sender_user_id == $user->id) { ?>
                                                        <div class="row m-t-20">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-5 messageSent pull-right m-b-10">
                                                                    <p><?= $message->message?></p>
                                                                    <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <? } else { ?>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                    <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                                                                    <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - CEO:</p>
                                                                    <? } else { ?>
                                                                    <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - <?= $message->sender->First()->getJoinedExpertise()->expertises->First()->title?>:</p>
                                                                    <? } ?>
                                                                    <p><?= $message->message?></p>
                                                                    <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <? } ?>
                                                <? } ?>
                                            </div>
                                            <div class="d-flex js-center">
                                                <hr class="col-sm-12 m-b-20">
                                            </div>
                                            <div class="row m-t-20">
                                                <div class="col-sm-12 text-center">
                                                    <textarea name="message" placeholder="Send your message..." class="input col-sm-10" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                    <button class="btn btn-inno pull-right">Send message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                            $groupChatMemberIds = [];
                            foreach($groupChat->getGroupChatMembers() as $groupChatMember){
                                array_push($groupChatMemberIds, $groupChatMember->id);
                            }
                        ?>
                        <div class="modal fade settingsGroupChat" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex js-center">
                                        <h4 class="modal-title text-center" id="modalLabel">Settings group chat</h4>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form action="/deleteGroupChatTeam" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="group_chat_id" value="<?= $groupChat->team_chat_group_id?>">
                                                    <button class="btn btn-inno btn-sm pull-right">Delete group chat</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form action="/saveGroupChatTeam" method="post" class="settingsGroupChatForm">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="team_id" value="<?= $team->id?>">
                                                    <input type="hidden" name="group_chat_id" value="<?= $groupChat->team_chat_group_id?>">
                                                    <div class="form-group">
                                                        <div class="d-flex fd-column">
                                                            <span>Title</span>
                                                            <input type="text" class="input col-sm-3" name="group_chat_title" value="<?= $groupChat->groupChat->First()->title?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="d-flex fd-column">
                                                            <span>Add members</span>
                                                            <div class="col-sm-12 d-flex p-l-0">
                                                                <div class="form-group col-sm-7 p-l-0">
                                                                    <select name="groupMembers" class="input col-sm-5 groupMembersSelect">
                                                                        <option value="" selected disabled>Choose members</option>
                                                                        <? foreach($team->getMembers() as $member) { ?>
                                                                            <? if($member->id != $user->id) { ?>
                                                                                <? if(!in_array($member->id, $groupChatMemberIds)) { ?>
                                                                                    <option value="<?= $member->id?>"><?= $member->getName()?></option>
                                                                                <? } ?>
                                                                            <? } ?>
                                                                        <? } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <span>Members in group: </span>
                                                                    <ul class="groupUsers">
                                                                        <? foreach($groupChat->getGroupChatMembers() as $groupChatMember) { ?>
                                                                            <li class="memberListItem" data-user-id="<?= $groupChatMember->id?>"><?= $groupChatMember->getName()?> <i data-user-id="<?= $groupChatMember->id?>" data-group-chat-id="<?= $groupChat->team_chat_group_id?>" class="zmdi zmdi-close c-orange removeFromGroupChat"></i></li>
                                                                        <? } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <button class="btn btn-inno pull-right">Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>

    <div class="modal fade " id="createGroupChat" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex js-center">
                    <h4 class="modal-title text-center" id="modalLabel">Create group chat</h4>
                </div>
                <form action="/my-team/createChatGroup" method="post" class="groupChatForm">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="team_id" value="<?= $team->id?>">
                    <div class="modal-body p-t-0">
                        <div class="form-group p-t-20 ">
                            <p class="m-0 p-0">Group title</p>
                            <input type="text" name="group_title" class="input">
                        </div>
                        <p class="f-19">Add group members</p>
                        <div class="col-sm-12 d-flex p-l-0">
                            <div class="form-group col-sm-7 p-l-0">
                                <select name="groupMembers" class="input col-sm-5 groupMembersSelect">
                                    <option value="" selected disabled>Choose members</option>
                                    <? foreach($team->getMembers() as $member) { ?>
                                        <? if($member->id != $user->id) { ?>
                                            <option value="<?= $member->id?>"><?= $member->getName()?></option>
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <ul class="groupUsers">

                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-inno pull-right">Create group</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/teamPageChat.js"></script>
@endsection