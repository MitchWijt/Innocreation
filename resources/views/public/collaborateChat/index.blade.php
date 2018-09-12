@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Network chat</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <small>Exchange ideas and network with each other!</small>
                </div>
            </div>
            <div class="hr col-sm-12"></div>
            <div class="row m-t-20 m-b-20">
                <div class="col-sm-12">
                    <div class="card card-lg">
                        <div class="card-block">
                            <div class="row d-flex js-center">
                                <div class="col-sm-8">
                                    <div class="o-scroll m-t-20 chatMessages" style="height: 500px;">
                                        <? foreach($messages as $message) { ?>
                                            <? if($message->sender_user_id == $user->id) { ?>
                                                <div class="row messageRowSent">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 pull-right m-b-10 messageSent">
                                                            <p class="message"><?= $message->message?></p>
                                                            <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? } else { ?>
                                                <? if($message->user->First()) { ?>
                                                    <div class="row messageRowReceived">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                <? if($message->team_id != null) { ?>
                                                                    <p class="c-orange m-0"><?= $message->user->getName()?> - <?= $message->user->team->team_name?>:</p>
                                                                <? } else { ?>
                                                                    <p class="c-orange m-0"><?= $message->user->getName()?>:</p>
                                                                <? } ?>
                                                                <p class="message"><?= $message->message?></p>
                                                                <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } else { ?>
                                                    <div class="row messageRowReceived">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                <p class="c-orange m-0">User doesn't exist anymore</p>
                                                                <p class="message"><?= $message->message?></p>
                                                                <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                    <div class="d-flex js-center">
                                        <hr class="col-sm-12 m-b-20">
                                    </div>
                                    <? if(isset($user)) { ?>
                                        <form action="" method="post" class="sendCollaborateMessage">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" class="userId" value="<?= $user->id?>">
                                            <input type="hidden" name="sender_user_id" value="">

                                            <div class="row m-t-20">
                                                <div class="col-sm-12 text-center">
                                                    <textarea name="teamMessage" placeholder="Send your message..." class="input col-sm-10 messageInput" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                    <button type="button" class="btn btn-inno pull-right sendMessageBtn" data-sender-user-id="<?= $user->id?>">Send message</button>
                                                </div>
                                            </div>
                                        </form>
                                    <? } else { ?>
                                        <div class="text-center">
                                            <p><a class="regular-link" href="/login?register=1">Create a free account</a> or <a class="regular-link" href="/login">login</a> to participate!</p>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? if(isset($user)) { ?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/getstream/dist/js_min/getstream.js"></script>
        <script type="text/javascript">
            var client = stream.connect('ujpcaxtcmvav', null, '40873');
            var user1 = client.feed('user', '1', 'l4MSbS6zzkMXpXs0KK4GMMw-sjc');
            function callback(data) {
                console.log(data);
                if($(".userId").val() != data["new"][0]["userId"]) {
                    var message = $('.messageRowReceived').first().clone();
                    var allMessages = $(".chatMessages");
                    $(message).appendTo(allMessages);
                    message.find(".messageReceived").find(".message").text(data["new"][0]["message"]);
                    message.find(".messageReceived").find(".timeSent").text(data["new"][0]["timeSent"]);
                    $(".messageInput").val("");

                    setTimeout(function(){
                        var objDiv = $(".chatMessages");
                        if (objDiv.length > 0) {
                            objDiv[0].scrollTop = objDiv[0].scrollHeight;
                        }
                    }, 600);
                }
            }
            function successCallback() {
                console.log('now listening to changes in realtime');
            }

            function failCallback(data) {
                alert('something went wrong, check the console logs');
                console.log(data);
            }
            user1.subscribe(callback).then(successCallback, failCallback);
        </script>
    <? } ?>
@endsection
@section('pagescript')
    <script src="/js/collaborate/index.js"></script>
@endsection