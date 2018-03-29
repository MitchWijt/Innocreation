@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Assistance tickets received</h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success m-b-0 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <hr class="m-b-20 col-sm-11">
            <div class="d-flex js-center">
                <? foreach($receivedAssistanceTickets as $assistanceTicket) { ?>
                    <div class="receivedAssistanceTicket">
                        <div class="card">
                            <div class="card-block">
                                <div class="text-center">
                                    <p class="f-18 m-t-10">Task: <?= $assistanceTicket->title?></p>
                                    <hr class="col-sm-9">
                                    <div class="row m-t-20">
                                        <div class="col-sm-12 d-flex fd-row js-center">
                                            <img class="circle circleSmall m-0" src="<?= $assistanceTicket->creator->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->creator->First()->firstname?>">
                                            <p class="m-l-20"><?= $assistanceTicket->creator->First()->getName()?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-inno btn-sm col-sm-3 m-b-20 openModalReceivedAssistanceModal">Open</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade receivedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header col-sm-12 d-flex">
                                        <div class="col-sm-4 d-flex m-t-10">
                                            <img class="circle circleSmall m-0 " src="<?= $assistanceTicket->creator->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->creator->First()->firstname?>">
                                            <p class="col-sm-9"><?= $assistanceTicket->creator->First()->getName()?></p>
                                        </div>
                                        <div class="col-sm-3 m-t-10">
                                            <p class="f-18"><?= $assistanceTicket->title?></p>
                                        </div>
                                        <div class="col-sm-2 m-r-20">
                                            <button class="btn btn-inno btn-sm">Complete ticket</button>
                                        </div>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">
                                            <? foreach($assistanceTicket->getMessages() as $message) { ?>
                                                <? if($message->sender_user_id == $user->id) { ?>
                                                <div class="row c-gray sendedMessageAjax">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 messageSent pull-right m-b-10">
                                                            <p class="message"><?= $message->message?></p>
                                                            <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <? } else { ?>
                                                    <div class="row c-gray">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                                                                    <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - CEO:</p>
                                                                <? } else { ?>
                                                                    <p class="c-orange m-0"><?= $message->sender->First()->getName()?></p>
                                                                <? } ?>
                                                                <p><?= $message->message?></p>
                                                                <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                        <div class="d-flex js-center">
                                            <hr class="col-sm-12 m-b-20">
                                        </div>
                                        <form action="" method="post" class="sendReceivedAssistanceMessageForum">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" class="ticket_id" name="ticket_id" value="<?=$assistanceTicket->id?>">
                                            <input type="hidden" class="sender_user_id" name="sender_user_id" value="<?=$user->id?>">
                                            <input type="hidden" class="receiver_user_id" name="receiver_user_id" value="<?= $assistanceTicket->creator->First()->id?>">
                                            <div class="row m-t-20">
                                                <div class="col-sm-12 text-center">
                                                    <textarea name="assistanceTicketMessage" placeholder="Send your message..." class="input col-sm-10 assistanceTicketMessage" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                    <button type="button" class="btn btn-inno pull-right sendMessageReceivedAssistance">Send message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Assistance tickets sended</h1>
            </div>
            <hr class="m-b-20 col-sm-11">
            <div class="d-flex js-center">
                <? foreach($sendedAssistanceTickets as $assistanceTicket) { ?>
                    <div class="sendedAssistanceTicket">
                        <div class="card ">
                            <div class="card-block">
                                <div class="text-center">
                                    <p class="f-18 m-t-10">Task: <?= $assistanceTicket->title?></p>
                                    <hr class="col-sm-9">
                                    <div class="row m-t-20">
                                        <div class="col-sm-12 d-flex fd-row js-center">
                                            <img class="circle circleSmall m-0" src="<?= $assistanceTicket->receiver->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->receiver->First()->firstname?>">
                                            <p class="m-l-20"><?= $assistanceTicket->receiver->First()->getName()?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-inno btn-sm col-sm-3 m-b-20">Open</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade sendedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header col-sm-12 d-flex">
                                        <div class="col-sm-4 d-flex m-t-10">
                                            <img class="circle circleSmall m-0 " src="<?= $assistanceTicket->receiver->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->receiver->First()->firstname?>">
                                            <p class="col-sm-9"><?= $assistanceTicket->receiver->First()->getName()?></p>
                                        </div>
                                        <div class="col-sm-3 m-t-10">
                                            <p class="f-18"><?= $assistanceTicket->title?></p>
                                        </div>
                                        <div class="col-sm-2 m-r-20">
                                            <button class="btn btn-inno btn-sm">Complete ticket</button>
                                        </div>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">
                                            <? foreach($assistanceTicket->getMessages() as $message) { ?>
                                            <? if($message->sender_user_id == $user->id) { ?>
                                            <div class="row c-gray sendedMessageAjax">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-5 messageSent pull-right m-b-10">
                                                        <p class="message"><?= $message->message?></p>
                                                        <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <? } else { ?>
                                            <div class="row c-gray">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                        <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                                                        <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - CEO:</p>
                                                        <? } else { ?>
                                                        <p class="c-orange m-0"><?= $message->sender->First()->getName()?></p>
                                                        <? } ?>
                                                        <p><?= $message->message?></p>
                                                        <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <? } ?>
                                            <? } ?>
                                        </div>
                                        <div class="d-flex js-center">
                                            <hr class="col-sm-12 m-b-20">
                                        </div>
                                        <form action="" method="post" class="sendSendedAssistanceMessageForum">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" class="ticket_id" name="ticket_id" value="<?=$assistanceTicket->id?>">
                                            <input type="hidden" class="sender_user_id" name="sender_user_id" value="<?=$user->id?>">
                                            <input type="hidden" class="receiver_user_id" name="receiver_user_id" value="<?= $assistanceTicket->receiver->First()->id?>">
                                            <div class="row m-t-20">
                                                <div class="col-sm-12 text-center">
                                                    <textarea name="assistanceTicketMessage" placeholder="Send your message..." class="input col-sm-10 assistanceTicketMessage" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                    <button type="button" class="btn btn-inno pull-right sendMessageSendedAssistance">Send message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceAssistanceTickets.js"></script>
@endsection