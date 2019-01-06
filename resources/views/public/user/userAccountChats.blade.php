@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container-fluid">
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My chats</h1>
            </div>
            <div class="hr col-md-12"></div>
            <div class="row" style="border-right: 1px solid #77787a">
                <div class="col-3">
                    <? if(\Illuminate\Support\Facades\Session::has("userChatId")) { ?>
                        <input type="hidden" class="userChatId" value="<?= \Illuminate\Support\Facades\Session::get("userChatId")?>">
                    <? } else { ?>
                        <input type="hidden" class="userChatId" value="0">
                    <? } ?>
                    <input type="hidden" class="streamToken" value="<?= $streamToken?>">
                    <input type="hidden" class="userId" value="<?= $user_id?>">
                    <form action="/searchChatUsers" class="searchChatUsersForm @mobile text-center @endmobile" method="post">
                        <input type="hidden" class="url_content" name="url_content" value="<? if(isset($urlParameter)) echo $urlParameter?>">
                        <input type="hidden" class="url_content_chat" name="url_content_chat" value="<? if(isset($urlParameterChat)) echo $urlParameterChat?>">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="text" placeholder="Search in my chats..." class="searchChatUsers input-fat m-t-20 form-control" name="searchChatUsers">
                    </form>
                    <? if(isset($searchedUserChats)) {
                        $eachValue = $searchedUserChats;
                    } else {
                        $eachValue = $userChats;
                    } ?>
                    <? if(count($eachValue) < 1) { ?>
                        <p class="text-center">No users found</p>
                    <? } ?>
                    <? foreach($eachValue as $userChat) { ?>
                        <div class="row m-t-10">
                            <div class="col-3">
                                <div class="avatar" style="background: url('<?= $userChat['user']->getProfilePicture()?>')"></div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p class="f-16 m-b-0"><?= $userChat['user']->getName()?></p>

                                    </div>
                                    <div class="col-sm-4">
                                        <span class="c-dark-grey f-12 m-r-20 pull-right"><?= $userChat['recentChat']->time_sent?></span>
                                    </div>
                                </div>
                                <div class="d-flex m-r-10">
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
                        <div class="hr-dark"></div>
                    <? } ?>
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
