@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My chats</h1>
            </div>
            <div class="hr col-md-12"></div>
            <div class="row">
                <div class="col-md-6">
                    <form action="/searchChatUsers" class="searchChatUsersForm" method="post">
                        <input type="hidden" class="url_content" name="url_content" value="<? if(isset($urlParameter)) echo $urlParameter?>">
                        <input type="hidden" class="url_content_chat" name="url_content_chat" value="<? if(isset($urlParameterChat)) echo $urlParameterChat?>">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="text" placeholder="Search users..." class="searchChatUsers input m-t-20" name="searchChatUsers">
                    </form>
                    <? if(isset($searchedUsers)) { ?>
                        <div class="userChatSearchBar o-scroll" style="min-height: 100px;">
                            <? foreach($searchedUsers as $searchedUser) { ?>
                                <form action="/selectChatUser" method="post" class="searchedUserForm">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="creator_user_id" value="<?=$user_id?>">
                                    <input type="hidden" name="receiver_user_id" value="<?=$searchedUser->id?>">
                                    <div class="userCircle">
                                        <div class="d-flex fd-column m-t-20">
                                            <div class="col-md-4 text-center">
                                                <img class="circle circleImage m-0 text-center" src="<?= $searchedUser->getProfilePicture()?>" alt="">
                                                <p class=" m-b-0"><?= $searchedUser->getName()?></p>
                                                <button class="btn btn-inno btn-sm">Start chat</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <? } ?>
                        </div>
                    <? } ?>
                </div>
                <div class="d-flex fd-column m-t-20 col-md-6">
                    <? if(isset($userChats)) { ?>
                        <? foreach($userChats as $userChat) { ?>
                            <div class="m-b-10">
                                <? if($userChat->creator_user_id == 1) { ?>
                                    <div class="row d-flex js-center">
                                        <div class="col-md-12">
                                        <div class="card text-center" style="height: 90px;">
                                            <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                <img class="circle circleImage m-0" src="/images/profilePicturesTeams/cartwheel.png" alt="">
                                                <p class="f-22 m-t-15 m-b-5 p-0">Innocreation</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <? } ?>
                                <? if($userChat->creator_user_id != 1) { ?>
                                    <? if($userChat->creator) { ?>
                                        <div class="row d-flex js-center userChat" data-chat-id="<?= $userChat->id?>">
                                            <div class="col-md-12">
                                                <div class="card text-center p-relative" style="height: 90px;">
                                                    <i class="zmdi zmdi-close c-orange p-absolute deleteChat" data-chat-id="<?= $userChat->id?>" style="right: 10px; top: 5px;"></i>
                                                    <? if($userChat->receiver_user_id == $user_id) { ?>
                                                        <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                            <img class="circle circleImage m-0" src="<?=$userChat->creator->getProfilePicture()?>" alt="">
                                                            <p class="f-22 m-t-15 m-b-5 p-0"><?=$userChat->creator->firstname?></p>
                                                            <? if($userChat->creator->team_id != null) { ?>
                                                            <div class="d-flex fd-column">
                                                                <p class="f-20 m-t-15 m-b-0"><?= $userChat->creator->team->team_name?></p>
                                                                <span class="f-13 c-orange"><?if($userChat->creator->team->ceo_user_id == $userChat->creator->id) echo "Team leader"?></span>
                                                            </div>
                                                            <? } ?>
                                                        </div>
                                                    <? } else { ?>
                                                        <? if($userChat->receiver) { ?>
                                                            <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                                <img class="circle circleImage m-0" src="<?=$userChat->receiver->getProfilePicture()?>" alt="">
                                                                <p class="f-22 m-t-15 m-b-5 p-0"><?=$userChat->receiver->firstname?></p>
                                                                <? if($userChat->receiver->team_id != null) { ?>
                                                                    <div class="d-flex fd-column">
                                                                        <p class="f-20 m-t-15 m-b-0"><?= $userChat->receiver->team->team_name?></p>
                                                                        <span class="f-13 c-orange"><?if($userChat->receiver->team->ceo_user_id == $userChat->receiver->id) echo "Team leader"?></span>
                                                                    </div>
                                                                <? } ?>
                                                            </div>
                                                        <? } else { ?>
                                                            <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                                <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25 m-t-15"></i></div>
                                                                <p class="f-22 m-t-15 m-b-5 p-0">User doesn't exist anymore</p>
                                                            </div>
                                                        <? } ?>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <? } else { ?>
                                        <div class="row d-flex js-center userChat" data-chat-id="<?= $userChat->id?>">
                                            <div class="card text-center p-relative" style="height: 90px;">
                                                <i class="zmdi zmdi-close c-orange p-absolute deleteChat" data-chat-id="<?= $userChat->id?>" style="right: 10px; top: 5px;"></i>
                                                <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-chat-id="<?= $userChat->id?>">
                                                    <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25 m-t-15"></i></div>
                                                    <p class="f-22 m-t-15 m-b-5 p-0">User doesn't exist anymore</p>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                                <div class="collapse collapseExample userChatTextarea" data-chat-id="<?= $userChat->id?>">
                                    <div class="card card-block">
                                        <form action="" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" class="sender_user_id" name="sender_user_id" value="<?=$user_id?>">
                                            <input type="hidden" class="user_chat_id" name="user_chat_id" value="<?=$userChat->id?>">
                                            <div class="col-sm-12 o-scroll userChatMessages" data-chat-id="<?= $userChat->id?>" style="max-height: 200px;">

                                            </div>
                                            <hr>
                                            <div class="row m-t-20">
                                                <div class="col-sm-12 text-center">
                                                    <textarea name="message" placeholder="Send your message..." class="input col-sm-10 messageInput" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                    <button class="btn btn-inno pull-right sendUserMessage" type="button">Send message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountChats.js"></script>
@endsection
