@extends("layouts.app")
<link rel="stylesheet" href="/css/user/userAccountChat.css">
<link rel="stylesheet" href="/css/responsiveness/userChats/userAccountChats.css">
@section("content")
    <div class="d-flex grey-background">
        <div class="container-fluid p-0">
            <div class="row m-r-0">
                <div class="col-sm-3 p-0 text-center" style="border-right: 1px solid #77787a">
                    <h1 class="f-25 p-t-10">My chats</h1>
                </div>
                @notmobile
                    <div class="col-sm-9 chatContentHeader">

                    </div>
                @endnotmobile
            </div>
            <div class="hr col-md-12"></div>
            <div class="row m-r-0">
                <div class="@mobile col-12 @elsedesktop col-3 @endmobile p-l-15 p-r-0" style="border-right: 1px solid #77787a;">
                    <? if(\Illuminate\Support\Facades\Session::has("userChatId")) { ?>
                        <input type="hidden" class="userChatId" value="<?= \Illuminate\Support\Facades\Session::get("userChatId")?>">
                    <? } else { ?>
                        <input type="hidden" class="userChatId" value="0">
                    <? } ?>
                    <input type="hidden" class="streamToken" value="<?= $streamToken?>">
                    <input type="hidden" class="userId" value="<?= $user_id?>">
                    <form action="/searchChatUsers" class="searchChatUsersForm @mobile text-center @endmobile p-r-10 p-l-10" method="post">
                        <input type="hidden" class="url_content" name="url_content" value="<? if(isset($urlParameter)) echo $urlParameter?>">
                        <input type="hidden" class="url_content_chat" name="url_content_chat" value="<? if(isset($urlParameterChat)) echo $urlParameterChat?>">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="text" placeholder="Search in my chats..." class="searchChatUsers input-fat m-t-20 form-control p-10" name="searchChatUsers">
                    </form>
                    <? if(isset($searchedUserChats)) {
                        $eachValue = $searchedUserChats;
                    } else {
                        $eachValue = $userChats;
                    }
                    ?>

                    <? if(count($eachValue) < 1) { ?>
                        <p class="text-center">No users found</p>
                    <? } ?>
                    <div class="o-scroll" style="height: 72vh; position: relative;">
                        <? foreach($eachValue as $userChat) { ?>
                            <?

                            ?>
                            <div class="row m-t-10 p-t-10 p-b-10 m-r-0 c-pointer chatItem chat-<?= $userChat['userchat']->id?>" data-chat-id="<?= $userChat['userchat']->id?>" data-receiver-user-id="<?=$userChat['user']->id?>">
                                <div class="col-3 p-r-0 p-l-20">
                                    <div class="avatar p-relative" style="background: url('<?= $userChat['user']->getProfilePicture()?>')">
                                        <? if($userChat['user']->active_status == "online") { ?>
                                            <i class="zmdi zmdi-circle f-15 c-green p-absolute onlineDot" data-user-id="<?= $userChat['user']->id?>" style="top:4%; right: 5%"></i>
                                        <? } ?>
                                    </div>
                                </div>
                                <div class="col-9 p-r-0 userDetails">
                                    <div class="d-flex js-between">
                                        <p class="f-16 m-b-0"><?= $userChat['user']->getName()?> <i class="zmdi zmdi-circle f-13 c-orange unreadNotification unseen-<?= $userChat['userchat']->id?> <? if($userChat['userchat']->getUnreadMessages($user_id) < 1 ) echo "hidden";?>" data-user-chat-id="<?= $userChat['userchat']->id?>"></i></p>
                                        <span class="c-dark-grey f-12 m-r-20 pull-right timesent"><?= $userChat['recentChat']->time_sent?></span>
                                    </div>
                                    <div class="d-flex m-r-20 p-r-10">
                                        <div class="recentMessage o-hidden" style="white-space: nowrap; text-overflow: ellipsis">
                                            <? if($userChat['recentChat']->sender_user_id == $user_id) { ?>
                                                <span class="f-12 p-0 m-b-0" style="color: #77787a !important"><?= strip_tags($userChat['recentChat']->message)?></span>
                                            <? } else { ?>
                                                <span class="f-12 p-0 m-b-0" style="color: #77787a !important;"><?= strip_tags($userChat['recentChat']->message)?></span>
                                            <? } ?>
                                        </div>
                                        <? if($userChat['recentChat']->sender_user_id != $user_id) { ?>
                                            <i class="zmdi zmdi-check-all c-dark-grey f-12 m-l-5 m-t-5"></i>
                                        <? } ?>
                                        <? if($userChat['recentChat']->seen_at != null && $userChat['recentChat']->sender_user_id == $user_id) { ?>
                                            <div class="avatar-msg-seen img p-t-0 p-r-5 p-l-5" style="background: url('<?= $userChat['user']->getProfilePicture()?>'); margin-top: 5px !important"></div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                @notmobile
                    <div class="col-sm-9">
                        <div class="chatContent o-scroll" style="height: calc(100vh - 230px);">

                        </div>
                        <div class="row" style="border-top: 1px solid #77787a;">
                            <div class="col-sm-10">
                                <textarea name="userMessage" class="input userMessageInput m-t-10  input-transparant c-black col-sm-12" id="emojiArea" placeholder="Type your message..."></textarea>
                            </div>
                            <div class="col-sm-2 m-t-10 hidden actions">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis" data-toggle="popover" data-content='<?= view("/public/shared/_popoverEmojiGeneric", compact("emojis", 'userChat'))?>'></i>
                                    </div>
                                    <div class="col-sm-7 p-l-0 p-r-10 sendBtn hidden">
                                        <input type="hidden" class="sender_user_id" value="<?= $user_id?>">
                                        <button class="btn btn-inno btn-sm  btn-block sendUserMessage" data-chat-id="">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endnotmobile
            </div>
        </div>
    </div>
    @mobile
        <div class="slideMessagesMobile hidden">
            <span class="c-orange f-15 backToUserChats"><i class="zmdi zmdi-long-arrow-left m-l-10 m-t-20"></i> Back</span>
            <div class="chatContentHeader p-t-10">

            </div>
            <div class="chatContent o-scroll m-l-5" style="height: 59vh;">

            </div>
            <div class="p-r-0" style="border-top: 1px solid #77787a; min-height: 50px">
                <div class="col-12 p-0">
                    <textarea name="userMessage" class="input userMessageInput m-t-10  input-transparant c-black col-sm-12 p-r-0" id="emojiArea" placeholder="Type your message..."></textarea>
                </div>
            </div>
            <div class="d-flex js-between hidden actions p-b-20 p-l-10 col-sm-12">
                <div class="text-center">
                    <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis" data-toggle="popover" data-content='<?= view("/public/shared/_popoverEmojiGeneric", compact("emojis", 'userChat'))?>'></i>
                </div>
                <div class="p-r-25 sendBtn hidden">
                    <input type="hidden" class="sender_user_id" value="<?= $user_id?>">
                    <button class="btn btn-inno btn-sm btn-block sendUserMessage" data-chat-id="">Send</button>
                </div>
            </div>
        </div>
    @endmobile
    <script src="/js/stream/stream.min.js"></script>
    <script defer async type="text/javascript">
        var client = stream.connect('ujpcaxtcmvav', null, '40873');
        var user1 = client.feed('user', '<?= $user_id?>', '<?= $streamToken?>');

        function callback(data) {
            $(".unreadNotification").each(function () {
               var userChatId = $(this).data("user-chat-id");
               if(!$(".chat-" + userChatId).hasClass("activeChat")) {
                   if (userChatId == data["new"][0]["userChat"]) {
                       $(this).removeClass("hidden");
                   }
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
