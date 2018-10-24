@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My chats</h1>
            </div>
            <div class="hr col-md-12"></div>
            <div class="row">
                <? if(\Illuminate\Support\Facades\Session::has("userChatId")) { ?>
                    <input type="hidden" class="userChatId" value="<?= \Illuminate\Support\Facades\Session::get("userChatId")?>">
                <? } ?>
                <input type="hidden" class="userChatId" value="0">
                <input type="hidden" class="streamToken" value="<?= $streamToken?>">
                <input type="hidden" class="userId" value="<?= $user_id?>">
                <div class="col-md-6">
                    <form action="/searchChatUsers" class="searchChatUsersForm @mobile text-center @endmobile" method="post">
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
                                                <div class="d-flex js-center ">
                                                    <div class="avatar" style="background: url('<?=$searchedUser->getProfilePicture()?>')"></div>
                                                </div>
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
                            <div class="m-b-10 chat">
                                <? if($userChat->creator_user_id == 1) { ?>
                                    <div class="row d-flex js-center">
                                        <div class="col-md-12">
                                            <div class="card text-center p-relative" style="height: 90px;">
                                                <? if($userChat->getUnreadMessages($user_id) > 0) { ?>
                                                    <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification" style="left: 10px; top: 5px;"></i>
                                                <? } ?>
                                                    <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification hidden" data-user-chat-id="<?= $userChat->id?>" style="left: 10px; top: 5px;"></i>
                                                    <div class="card-block chat-card d-flex js-around m-t-10" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
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
                                                    <? if($userChat->getUnreadMessages($user_id) > 0) { ?>
                                                        <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification" style="left: 10px; top: 5px;"></i>
                                                    <? } ?>
                                                    <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification hidden" data-user-chat-id="<?= $userChat->id?>" style="left: 10px; top: 5px;"></i>
                                                    <i class="zmdi zmdi-close c-orange p-absolute deleteChat" data-chat-id="<?= $userChat->id?>" style="right: 10px; top: 5px;"></i>
                                                    <? if($userChat->receiver_user_id == $user_id) { ?>
                                                        <? if($userChat->creator->active_status == "online") { ?>
                                                            <i class="zmdi zmdi-circle f-15 c-green p-absolute onlineDot" data-user-id="<?= $userChat->creator->id?>" style="left: 95px; top: 10px;"></i>
                                                        <? } ?>
                                                        <div class="card-block chat-card d-flex js-around m-t-10" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
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
                                                        <? if($userChat->receiver->active_status == "online") { ?>
                                                            <i class="zmdi zmdi-circle f-15 c-green p-absolute onlineDot" data-user-id="<?= $userChat->receiver->id?>" style="left: 95px; top: 10px;"></i>
                                                        <? } ?>
                                                            <div class="card-block chat-card d-flex js-around m-t-10" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
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
                                                            <div class="card-block chat-card d-flex js-around m-t-10" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
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
                                            <div class="col-md-12">
                                                <div class="card text-center p-relative" style="height: 90px;">
                                                    <i class="zmdi zmdi-close c-orange p-absolute deleteChat" data-chat-id="<?= $userChat->id?>" style="right: 10px; top: 5px;"></i>
                                                    <div class="card-block chat-card d-flex js-around m-t-10" data-chat-id="<?= $userChat->id?>">
                                                        <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25 m-t-15"></i></div>
                                                        <p class="f-22 m-t-15 m-b-5 p-0">User doesn't exist anymore</p>
                                                    </div>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/getstream/dist/js_min/getstream.js"></script>
    <script type="text/javascript">
        var client = stream.connect('ujpcaxtcmvav', null, '40873');
        var user1 = client.feed('user', '<?= $user_id?>', '<?= $streamToken?>');

        function callback(data) {
            $(".unreadNotification").each(function () {
               var userChatId = $(this).data("user-chat-id");
               if(userChatId == data["new"][0]["userChat"]){
                   $(this).removeClass("hidden");
               }
            });

            if(data["new"][0]["status"] && data["new"][0]["status"] == "online"){
                $(".onlineDot").each(function () {
                    var userId = $(this).data("user-id");
                    if(userId == data["new"][0]["userId"]){
                        $(this).removeClass("hidden");
                    } else {
                        $(this).addClass("hidden");
                    }
                });
            }


        }

        function successCallback() {
            console.log('now listening to changes in realtime');
        }

        function failCallback(data) {
            alert('something went wrong, check the console logs');
        }
        user1.subscribe(callback).then(successCallback, failCallback);
    </script>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountChats.js"></script>
@endsection
