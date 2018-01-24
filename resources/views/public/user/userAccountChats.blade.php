@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My chats</h1>
            </div>
            <div class="hr col-sm-12"></div>
            <div class="d-flex js-around">
                <div class="d-flex fd-column">
                    <form action="/searchChatUsers" class="searchChatUsersForm" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="text" placeholder="Search users..." class="searchChatUsers input m-t-20" name="searchChatUsers">
                    </form>
                    <? if(isset($searchedUsers)) { ?>
                        <div class="userChatSearchBar o-scroll" style="min-height: 100px;">
                            <? foreach($searchedUsers as $searchedUser) { ?>
                                <form action="/selectChatUser" method="post" class="searchedUserForm">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="sender_user_id" value="<?=$user_id?>">
                                    <input type="hidden" name="receiver_user_id" value="<?=$searchedUser->id?>">
                                    <div class="userCircle">
                                        <div class="d-flex fd-column  m-t-20">
                                            <div class="text-center">
                                                <img class="circle chatImage m-0 text-center" src="<?= $searchedUser->getProfilePicture()?>" alt="">
                                                <p class="text-center "><?= $searchedUser->getName()?></p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <? } ?>
                        </div>
                    <? } ?>
                </div>
                <div class="d-flex fd-column m-t-20">
                    <? $recentChats = [];?>
                    <? if(isset($userMessages)) { ?>
                        <? foreach($userMessages as $userMessage) { ?>
                            <? if(!in_array($userMessage->receiver_user_id, $recentChats)) { ?>
                            <? array_push($recentChats, $userMessage->receiver_user_id)?>
                                <div class="row d-flex js-center">
                                    <div class="card text-center">
                                        <div class="card-block chat-card" data-toggle="collapse" href=".collapseExample" aria-controls="collapseExample" aria-expanded="false" data-user-id="<?= $userMessage->receiver_user_id?>">
                                            <p class="f-z-rem m-b-5 p-0"><?=$userMessage->users->First()->firstname?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse collapseExample" id="" data-user-id="<?= $userMessage->receiver_user_id?>">
                                    <div class="card card-block">
                                        <form action="/sendMessageUser" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="receiver_user_id" value="<?=$userMessage->receiver_user_id?>">
                                            <input type="hidden" name="sender_user_id" value="<?=$user_id?>">
                                            <div class="col-sm-12">
                                            <? foreach($userMessage->getMessages($userMessage->receiver_user_id, $user_id) as $message) { ?>
                                                <? if($message->sender_user_id == $user_id) { ?>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <span class="pull-left f-12"><?=$message->time_sent?></span>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <p class="pull-right"><?=$message->message?></p>
                                                        </div>
                                                    </div>
                                                <? } else { ?>
                                                    <div class="row ">
                                                        <p class="col-sm-8 pull-left"><?=$message->message?></p>
                                                        <div class="col-sm-4">
                                                            <span class="pull-right"><?=$message->time_sent?></span>
                                                        </div>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                            </div>
                                            <hr>
                                            <div class="row m-t-20">
                                                <div class="col-sm-12 text-center">
                                                    <textarea name="message" placeholder="Send your message..." class="input col-sm-10" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                    <button class="btn btn-inno pull-right">Sent message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <? } ?>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/userAccountChats.js"></script>
@endsection
