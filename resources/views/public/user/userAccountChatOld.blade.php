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
                    <a href="/user/<?= $userChat->creator->slug?>">
                        <div class="avatar" style="background: url('<?=$userChat->creator->getProfilePicture()?>')"></div>
                    </a>
                    <p class="f-22 m-t-15 m-b-5 p-0"><?=$userChat->creator->firstname?></p>
                </div>
                <? } else { ?>
                <? if($userChat->receiver) { ?>
                <? if($userChat->receiver->active_status == "online") { ?>
                <i class="zmdi zmdi-circle f-15 c-green p-absolute onlineDot" data-user-id="<?= $userChat->receiver->id?>" style="left: 95px; top: 10px;"></i>
                <? } ?>
                <div class="card-block chat-card d-flex js-around m-t-10" data-user-id="<?= $userChat->receiver_user_id?>" data-chat-id="<?= $userChat->id?>">
                    <a href="/user/<?= $userChat->receiver->slug?>">
                        <div class="avatar" style="background: url('<?=$userChat->receiver->getProfilePicture()?>')"></div>
                    </a>
                    <p class="f-22 m-t-15 m-b-5 p-0"><?=$userChat->receiver->firstname?></p>
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
                        <textarea name="message" placeholder="Send your message..." class="input col-11 messageInput input-<?= $userChat->id?>" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-11 m-b-20 m-t-10">
                        <button class="btn btn-inno pull-right sendUserMessage" type="button">Send message</button>
                        <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis pull-right m-r-10" data-toggle="popover" data-content='<?= view("/public/shared/_popoverEmojiGeneric", compact("emojis", 'userChat'))?>'></i>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>