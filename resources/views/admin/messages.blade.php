@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">User messages</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12">
                                <div class="d-flex fd-column m-t-20">
                                    <? if(isset($userChats)) { ?>
                                        <? foreach($userChats as $userChat) { ?>
                                            <div class="m-b-10">
                                                <div class="row d-flex js-center">
                                                    <div class="card text-center" style="height: 90px;">
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
                                                <div class="row d-flex js-center">
                                                <div class="collapse collapseExample" data-chat-id="<?= $userChat->id?>">
                                                    <div class="card card-block">
                                                        <form action="/sendMessageUser" method="post">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" name="sender_user_id" value="1">
                                                            <input type="hidden" name="user_chat_id" value="<?=$userChat->id?>">
                                                            <div class="col-sm-12 o-scroll userChatMessages" style="max-height: 200px;">

                                                            </div>
                                                            <hr>
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
                                        <? } ?>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    }
                                });
                            }
                        });
                    }
                    setTimeout(function(){
                        getUserChatMessages();
                    }, 300);
                    setTimeout(function(){
                        var objDiv = $(".userChatMessages");
                        if (objDiv.length > 0){
                            objDiv[0].scrollTop = objDiv[0].scrollHeight;
                        }
                    }, 500);
                    setInterval(function () {
                        getUserChatMessages();
                    }, 20000);
                    $(this).collapse('toggle');
                }
            });
        });

//        $(document).ready(function () {
//            var user_id = $(".url_content").val();
//            var user_chat_id = $(".url_content_chat").val();
//            $(".collapse").each(function () {
//                if($(this).data("user-id") == user_id){
//                    function getUserChatMessages() {
//                        $.ajax({
//                            method: "POST",
//                            beforeSend: function (xhr) {
//                                var token = $('meta[name="csrf_token"]').attr('content');
//
//                                if (token) {
//                                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
//                                }
//                            },
//                            url: "/message/getUserChatMessages",
//                            data: {'user_chat_id': user_chat_id},
//                            success: function (data) {
//                                $(".collapse").each(function () {
//                                    if($(this).data("user-id") == user_id){
//                                        $(this).find(".userChatMessages").html(data);
//                                    }
//                                });
//                            }
//                        });
//                    }
//                    setTimeout(function(){
//                        getUserChatMessages();
//                    }, 300);
//                    setTimeout(function(){
//                        var objDiv = $(".userChatMessages");
//                        if (objDiv.length > 0){
//                            objDiv[0].scrollTop = objDiv[0].scrollHeight;
//                        }
//                    }, 500);
//                    setInterval(function () {
//                        getUserChatMessages();
//                    }, 20000);
//                    $(this).addClass("show");
//                }
//            });
//        });
    </script>
@endsection