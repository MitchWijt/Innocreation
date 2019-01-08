@extends("layouts.app")
<link rel="stylesheet" href="/css/user/userAccountChat.css">
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container-fluid p-0">
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
                <div class="row m-r-0">
                    <div class="col-sm-3 p-0 text-center m-l-15" style="border-right: 1px solid #77787a">
                        <h1 class="f-25 p-t-10">My chats</h1>
                    </div>
                    <div class="col-sm-8 chatContentHeader">

                    </div>
                </div>
            <div class="hr col-md-12"></div>
            <div class="row m-r-0">
                <div class="col-sm-3 m-l-15 p-0" style="border-right: 1px solid #77787a;">
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
                    } ?>
                    <? if(count($eachValue) < 1) { ?>
                        <p class="text-center">No users found</p>
                    <? } ?>
                    <div class="o-scroll" style="height: 80vh; position: relative;">
                        <? foreach($eachValue as $userChat) { ?>
                            <div class="row m-t-10 p-t-10 p-b-10 c-pointer chatItem chat-<?= $userChat['userchat']->id?>" data-chat-id="<?= $userChat['userchat']->id?>" data-receiver-user-id="<?=$userChat['user']->id?>">
                                <div class="col-sm-3 p-r-0 p-l-20">
                                    <div class="avatar" style="background: url('<?= $userChat['user']->getProfilePicture()?>')"></div>
                                </div>
                                <div class="col-sm-9 p-r-0">
                                    <div class="d-flex js-between">
                                        <p class="f-16 m-b-0"><?= $userChat['user']->getName()?></p>
                                        <span class="c-dark-grey f-12 m-r-20 pull-right"><?= $userChat['recentChat']->time_sent?></span>
                                    </div>
                                    <div class="d-flex m-r-10 p-r-10">
                                        <div class="recentMessage o-hidden" style="white-space: nowrap; text-overflow: ellipsis">
                                            <? if($userChat['recentChat']->sender_user_id == $user_id) { ?>
                                            <span class="f-12 p-0 m-b-0" style="color: #77787a !important"><?= $userChat['recentChat']->message?></span>
                                            <? } else { ?>
                                            <span class="f-12 p-0 m-b-0" style="color: #77787a !important;"><?= strip_tags($userChat['recentChat']->message)?></span>
                                            <? } ?>
                                        </div>
                                        <? if($userChat['recentChat']->sender_user_id != $user_id) { ?>
                                            <i class="zmdi zmdi-check-all c-dark-grey f-12 m-l-5 m-t-5"></i>
                                        <? } ?>
                                        <? if($userChat['recentChat']->seen_at != null && $userChat['recentChat']->sender_user_id == $user_id) { ?>
                                            <div class="avatar-msg-seen img p-t-0" style="background: url('<?= $userChat['user']->getProfilePicture()?>'); margin-top: 5px !important"></div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="chatContent o-scroll" style="max-height: 70vh">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/stream/stream.min.js"></script>
    <script defer async type="text/javascript">
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
