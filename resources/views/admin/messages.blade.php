@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-3 m-t-10">
                                    <h4 class="">User messages</h4>
                                </div>
                                <div class="col-sm-9 m-t-10 m-b-10">
                                    <form action="/admin/getSearchResultsUserChat" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <button class="btn btn-inno btn-sm pull-right m-l-10">Search</button>
                                        <input type="text" name="searchChatBackend" placeholder="Search users..." class="input pull-right">
                                    </form>
                                </div>
                            </div>
                            <div class="hr col-sm-12 m-b-20"></div>
                            <? if(isset($searchedUserChats)) { ?>
                                <? foreach($searchedUserChats as $userChat) { ?>
                                    <div class="m-b-10 chat">
                                        <div class="row d-flex js-center">
                                            <div class="col-md-7">
                                                <div class="card text-center p-relative" style="height: 90px;">
                                                    <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification hidden" data-user-chat-id="<?= $userChat->id?>" style="left: 10px; top: 5px;"></i>
                                                    <? if($userChat->receiver) { ?>
                                                    <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                        <img class="circle circleImage m-0" src="<?=$userChat->receiver->getProfilePicture()?>" alt="">
                                                        <p class="f-22 m-t-15 m-b-5 p-0"><?=$userChat->receiver->firstname?></p>
                                                        <? if($userChat->receiver->team_id != null) { ?>
                                                        <div class="d-flex fd-column">
                                                            <p class="f-20 m-t-15 m-b-0"><?= $userChat->receiver->team->First()->team_name?></p>
                                                            <span class="f-13 c-orange"><?if($userChat->receiver->team->First()->ceo_user_id == $userChat->receiver->id) echo "Team leader"?></span>
                                                        </div>
                                                        <? } ?>
                                                    </div>
                                                    <? } else { ?>
                                                    <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                        <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25 m-t-15"></i></div>
                                                        <p class="f-22 m-t-15 m-b-5 p-0">User doesn't exist anymore</p>
                                                    </div>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex js-center">
                                            <div class="col-md-7">
                                                <div class="collapse collapseExample userChatTextarea" data-chat-id="<?= $userChat->id?>">
                                                    <div class="card card-block">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" class="sender_user_id" name="sender_user_id" value="1">
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
                                                                    <button type="button" class="btn btn-inno pull-right sendUserMessage">Send message</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                            <? if(isset($userChats)) { ?>
                                <? foreach($userChats as $userChat) { ?>
                                    <? if($userChat->getUnreadMessages(1) > 0) { ?>
                                        <div class="m-b-10 chat">
                                            <div class="row d-flex js-center">
                                                <div class="col-md-7">
                                                    <div class="card text-center p-relative" style="height: 90px;">
                                                        <? if($userChat->getUnreadMessages(1) > 0) { ?>
                                                            <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification" style="left: 10px; top: 5px;"></i>
                                                        <? } ?>
                                                        <i class="zmdi zmdi-circle f-10 c-orange p-absolute unreadNotification hidden" data-user-chat-id="<?= $userChat->id?>" style="left: 10px; top: 5px;"></i>
                                                        <? if($userChat->receiver) { ?>
                                                            <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                            <img class="circle circleImage m-0" src="<?=$userChat->receiver->getProfilePicture()?>" alt="">
                                                            <p class="f-22 m-t-15 m-b-5 p-0"><?=$userChat->receiver->firstname?></p>
                                                            <? if($userChat->receiver->team_id != null) { ?>
                                                                <div class="d-flex fd-column">
                                                                    <p class="f-20 m-t-15 m-b-0"><?= $userChat->receiver->team->First()->team_name?></p>
                                                                    <span class="f-13 c-orange"><?if($userChat->receiver->team->First()->ceo_user_id == $userChat->receiver->id) echo "Team leader"?></span>
                                                                </div>
                                                            <? } ?>
                                                        </div>
                                                        <? } else { ?>
                                                            <div class="card-block chat-card d-flex js-around m-t-10" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                                                                <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25 m-t-15"></i></div>
                                                                <p class="f-22 m-t-15 m-b-5 p-0">User doesn't exist anymore</p>
                                                            </div>
                                                        <? } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-flex js-center">
                                                <div class="col-md-7">
                                                    <div class="collapse collapseExample userChatTextarea" data-chat-id="<?= $userChat->id?>">
                                                        <div class="card card-block">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                <input type="hidden" class="sender_user_id" name="sender_user_id" value="1">
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
                                                                        <button type="button" class="btn btn-inno pull-right sendUserMessage">Send message</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/getstream/dist/js_min/getstream.js"></script>
    <script>
        $(".chat-card").on("click",function () {
            var user_id = $(this).data("user-id");
            var user_chat_id = $(this).data("chat-id");
            var admin = 1;
            $(".collapse").each(function () {
                if($(this).data("chat-id") == user_chat_id){
                    function getUserChatMessages() {
                        $.ajax({
                            method: "POST",
                            beforeSend: function (xhr) {
                                var token = $('meta[name="csrf_token"]').attr('content');

                                if (token) {
                                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                }
                            },
                            url: "/message/getUserChatMessages",
                            data: {'user_chat_id': user_chat_id, 'admin' : admin},
                            success: function (data) {
                                $(".collapse").each(function () {
                                    if($(this).data("chat-id") == user_chat_id){
                                        $(this).find(".userChatMessages").html(data);
                                        $(this).parents(".chat").find(".unreadNotification").remove();
                                    }
                                });
                            }
                        });
                    }
                    setTimeout(function(){
                        getUserChatMessages();
                    }, 500);

                    var client = stream.connect('ujpcaxtcmvav', null, '40873');
                    var user1 = client.feed('user', 1, "l4MSbS6zzkMXpXs0KK4GMMw-sjc");

                    function callback(data) {
                        $(".userChatMessages").each(function () {
                            var userChatId = $(this).data("chat-id");
                            if(userChatId == data["new"][0]["userChat"]){
                                var message = $('.messageReceived').first().clone();
                                var allMessages = $(this);
                                message.appendTo(allMessages);
                                message.find(".message").text(data["new"][0]["message"]);
                                message.find(".timeSent").text(data["new"][0]["timeSent"]);
                                message.attr("style", "margin-top: 20px !important");
                                $(this).parents(".userChatTextarea").find(".messageInput").val("");
                            }
                        });

                    }

                    function successCallback() {
                        console.log('now listening to changes in realtime');
                    }

                    function failCallback(data) {
                        alert('something went wrong, check the console logs');
                        console.log(data);
                    }
                    user1.subscribe(callback).then(successCallback, failCallback);

                    setTimeout(function(){
                        console.log("scroll");
                        var objDiv = $(".userChatMessages");
                        if (objDiv.length > 0){
                            objDiv[0].scrollTop = objDiv[0].scrollHeight;
                        }
                    }, 1000);
                    $(this).collapse('toggle');
                }
            });
        });

        $(".sendUserMessage").on("click",function () {
            var user_chat_id = $(this).parents(".userChatTextarea").find(".user_chat_id").val();
            var sender_user_id = $(this).parents(".userChatTextarea").find(".sender_user_id").val();
            var message = $(this).parents(".userChatTextarea").find(".messageInput").val();
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/sendMessageUser",
                data: {'user_chat_id': user_chat_id, 'sender_user_id' : sender_user_id, 'message' : message},
                dataType: "JSON",
                success: function (data) {
                    var message = $('.messageSent').first().clone();
                    $(".userChatMessages").each(function () {
                        if($(this).data("chat-id") == user_chat_id){
                            var allMessages = $(this);
                            $(message).appendTo(allMessages);
                            message.find(".message").text(data['message']);
                            message.find(".timeSent").text(data['timeSent']);
                            $(this).parents(".userChatTextarea").find(".messageInput").val("");
                        }
                    });
                }
            });
            setTimeout(function(){
                $(".userChatMessages").each(function () {
                    if($(this).data("chat-id") == user_chat_id) {
                        var objDiv = $(this);
                        if (objDiv.length > 0) {
                            objDiv[0].scrollTop = objDiv[0].scrollHeight;
                        }
                    }
                });
            }, 500);
        });

        $(document).ready(function () {
            var client = stream.connect('ujpcaxtcmvav', null, '40873');
            var user1 = client.feed('user', '1', 'l4MSbS6zzkMXpXs0KK4GMMw-sjc');

            function callback(data) {
                $(".unreadNotification").each(function () {
                    var userChatId = $(this).data("user-chat-id");
                    if(userChatId == data["new"][0]["userChat"]){
                        $(this).removeClass("hidden");
                    }
                });

            }

            function successCallback() {
                console.log('now listening to changes in realtime');
            }

            function failCallback(data) {
                alert('something went wrong, check the console logs');
                console.log(data);
            }
            user1.subscribe(callback).then(successCallback, failCallback);
        });
    </script>
@endsection