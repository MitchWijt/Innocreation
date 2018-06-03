@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.workspace_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.workspace_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-25 @endmobile">Assistance tickets received</h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success m-b-0 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <hr class="m-b-20 col-sm-11">
            <? foreach($receivedAssistanceTickets as $assistanceTicket) { ?>
                <div class="row d-flex js-center m-b-20">
                    <? if($assistanceTicket) { ?>
                        <div class="receivedAssistanceTicket col-md-8">
                            <div class="card">
                                <div class="card-block receivedAssistanceTicketCard" data-ticket-id="<?= $assistanceTicket->id?>">
                                    <div class="text-center">
                                        <p class="f-18 m-t-10">Task: <?= $assistanceTicket->title?></p>
                                        <hr class="col-sm-9">
                                        <div class="row m-t-20 d-flex fd-row js-center">
                                            <img class="circle circleSmall m-0" src="<?= $assistanceTicket->creator->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->creator->First()->firstname?>">
                                            <p class="m-l-20"><?= $assistanceTicket->creator->First()->getName()?></p>
                                        </div>
                                        <div class="row text-center d-flex js-center">
                                            <button class="btn btn-inno btn-sm m-b-20 openModalReceivedAssistanceModal">Open</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade receivedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-ticket-id="<?= $assistanceTicket->id?>">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header col-sm-12 d-flex">
                                            <div class="col-sm-4 d-flex m-t-10">
                                                <img class="circle circleSmall m-0 " src="<?= $assistanceTicket->creator->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->creator->First()->firstname?>">
                                                <p class="col-sm-9"><?= $assistanceTicket->creator->First()->getName()?></p>
                                            </div>
                                            <div class="col-sm-3 m-t-10">
                                                <p class="f-18"><a class="regular-link" href="/my-team/workspace/short-term-planner/<?= $assistanceTicket->task->short_term_planner_board_id?>?task_id=<?= $assistanceTicket->task_id?>"><?= $assistanceTicket->title?></a></p>
                                            </div>
                                            <div class="col-sm-2 m-r-20">
                                                <form action="/workspace/completeAssistanceTicket" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="ticket_id" value="<?=$assistanceTicket->id?>">
                                                    <button class="btn btn-inno btn-sm">Complete ticket</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-body ">
                                            <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">

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
                    <? } else { ?>
                        <div class="receivedAssistanceTicket">
                            <div class="card">
                                <div class="card-block">
                                    <div class="text-center">
                                        <p class="f-18 m-t-10">Task: <?= $assistanceTicket->title?></p>
                                        <hr class="col-sm-9">
                                        <div class="row m-t-20">
                                            <div class="col-sm-12 d-flex fd-row js-center">
                                                <div class="circle circleSmall"><i class="zmdi zmdi-eye-off f-10"></i></div>
                                                <p class="m-l-20">User doesn't exist anymore</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-inno btn-sm m-b-20 openModalReceivedAssistanceModal">Open</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade receivedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header col-sm-12 d-flex">
                                            <div class="col-sm-4 d-flex m-t-30">
                                                <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25 m-t-15"></i></div>
                                                <p class="col-sm-12 f-14">User doesn't exist anymore</p>
                                            </div>
                                            <div class="col-sm-3 m-t-10">
                                                <p class="f-18"><a class="regular-link" href="/my-team/workspace/short-term-planner/<?= $assistanceTicket->task->short_term_planner_board_id?>?task_id=<?= $assistanceTicket->task_id?>"><?= $assistanceTicket->title?></a></p>
                                            </div>
                                            <div class="col-sm-2 m-r-20">
                                                <form action="/workspace/completeAssistanceTicket" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="ticket_id" value="<?=$assistanceTicket->id?>">
                                                    <button class="btn btn-inno btn-sm">Complete ticket</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-body ">
                                            <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">
                                                <? foreach($assistanceTicket->getMessages() as $message) { ?>
                                                    <? if($message->sender_user_id == $user->id) { ?>
                                                    <div class="row c-gray sendedMessageAjax">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5 messageSent pull-right m-b-10">
                                                                <p class="message break-word"><?= $message->message?></p>
                                                                <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <? } else { ?>
                                                        <div class="row c-gray">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                    <p class="c-orange m-0">User doesn't exist anymore</p>
                                                                    <p class="break-word"><?= $message->message?></p>
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
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p>Unable to write messages. User doesn't exist anymore</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            <? } ?>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-25 @endmobile">Assistance tickets sended</h1>
            </div>
            <hr class="m-b-20 col-sm-11">
            <? foreach($sendedAssistanceTickets as $assistanceTicket) { ?>
                <div class="row d-flex js-center m-b-20">
                    <? if($assistanceTicket) { ?>
                        <div class="sendedAssistanceTicket col-md-7">
                            <div class="card">
                                <div class="card-block sendedAssistanceTicketCard" data-ticket-id="<?= $assistanceTicket->id?>">
                                    <div class="text-center">
                                        <p class="f-18 m-t-10">Task: <?= $assistanceTicket->title?></p>
                                        <hr class="col-md-9">
                                        <div class="row m-t-20 d-flex fd-row js-center">
                                            <img class="circle circleSmall m-0" src="<?= $assistanceTicket->receiver->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->receiver->First()->firstname?>">
                                            <p class="m-l-20"><?= $assistanceTicket->receiver->First()->getName()?></p>
                                        </div>
                                        <div class="row d-flex js-center">
                                            <button class="btn btn-inno btn-sm m-b-20">Open</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade sendedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-ticket-id="<?= $assistanceTicket->id?>">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header col-sm-12 d-flex">
                                            <div class="col-sm-4 d-flex m-t-10">
                                                <img class="circle circleSmall m-0 " src="<?= $assistanceTicket->receiver->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->receiver->First()->firstname?>">
                                                <p class="col-sm-9"><?= $assistanceTicket->receiver->First()->getName()?></p>
                                            </div>
                                            <div class="col-sm-3 m-t-10">
                                                <p class="f-18"><a class="regular-link" href="/my-team/workspace/short-term-planner/<?= $assistanceTicket->task->short_term_planner_board_id?>?task_id=<?= $assistanceTicket->task_id?>"><?= $assistanceTicket->title?></a></p>
                                            </div>
                                            <div class="col-sm-2 m-r-20">
                                                <form action="/workspace/completeAssistanceTicket" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="ticket_id" value="<?=$assistanceTicket->id?>">
                                                    <button class="btn btn-inno btn-sm">Complete ticket</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-body ">
                                            <div class="o-scroll m-t-20 sendedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">

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
                    <? } else { ?>
                    <div class="sendedAssistanceTicket">
                        <div class="card ">
                            <div class="card-block">
                                <div class="text-center">
                                    <p class="f-18 m-t-10">Task: <?= $assistanceTicket->title?></p>
                                    <hr class="col-sm-9">
                                    <div class="row m-t-20">
                                        <div class="col-sm-12 d-flex fd-row js-center">
                                            <div class="circle circleSmall"><i class="zmdi zmdi-eye-off f-10"></i></div>
                                            <p class="m-l-20">User doesn't exist anymore</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn btn-inno btn-sm m-b-20">Open</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade sendedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header col-sm-12 d-flex">
                                        <div class="col-sm-4 d-flex m-t-30">
                                            <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25"></i></div>
                                            <p class="col-sm-12 f-14">User doesn't exist anymore</p>
                                        </div>
                                        <div class="col-sm-3 m-t-10">
                                            <p class="f-18"><a class="regular-link" href="/my-team/workspace/short-term-planner/<?= $assistanceTicket->task->short_term_planner_board_id?>?task_id=<?= $assistanceTicket->task_id?>"><?= $assistanceTicket->title?></a></p>
                                        </div>
                                        <div class="col-sm-2 m-r-20">
                                            <form action="/workspace/completeAssistanceTicket" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" name="ticket_id" value="<?=$assistanceTicket->id?>">
                                                <button class="btn btn-inno btn-sm">Complete ticket</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">
                                            <? foreach($assistanceTicket->getMessages() as $message) { ?>
                                                <? if($message->sender_user_id == $user->id) { ?>
                                                    <div class="row c-gray sendedMessageAjax">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5 messageSent pull-right m-b-10">
                                                                <p class="message break-word"><?= $message->message?></p>
                                                                <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } else { ?>
                                                    <div class="row c-gray">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                <p class="c-orange m-0">User doesn't exist anymore</p>
                                                                <p class="break-word"><?= $message->message?></p>
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
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p>Unable to write messages. User doesn't exist anymore</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <? } ?>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-23 @endmobile">Assistance tickets completed</h1>
            </div>
            <hr class="m-b-20 col-sm-11">
            <? foreach($completedAssistanceTickets as $assistanceTicket) { ?>
                <div class="d-flex js-center m-b-20 row completedAssistanceTicketRow" data-ticket-id="<?= $assistanceTicket->id?>">
                        <? if($assistanceTicket) { ?>
                            <div class="completedAssistanceTicket col-md-7" data-ticket-id="<?= $assistanceTicket->id?>">
                                <div class="card">
                                    <div class="card-block">
                                        <span class="removeAssistanceTicket" data-ticket-id="<?= $assistanceTicket->id?>"><i class="zmdi zmdi-close pull-right c-orange m-t-5 m-r-10"></i></span>
                                        <div class="text-center">
                                            <p class="f-18 m-t-10 m-l-20">Task: <?= $assistanceTicket->title?></p>
                                            <hr class="col-md-9">
                                            <div class="row m-t-20 d-flex fd-row js-center">
                                                <? if($assistanceTicket->creator_user_id == $user->id) { ?>
                                                    <img class="circle circleSmall m-0" src="<?= $assistanceTicket->receiver->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->receiver->First()->firstname?>">
                                                    <p class="m-l-20"><?= $assistanceTicket->receiver->First()->getName()?></p>
                                                <? } else { ?>
                                                    <img class="circle circleSmall m-0" src="<?= $assistanceTicket->creator->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->creator->First()->firstname?>">
                                                    <p class="m-l-20"><?= $assistanceTicket->creator->First()->getName()?></p>
                                                <? } ?>
                                            </div>
                                            <div class="row text-center d-flex js-center">
                                                <button class="btn btn-inno btn-sm m-b-20">Open</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade completedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header col-sm-12 d-flex">
                                                <div class="col-sm-4 d-flex m-t-10">
                                                    <? if($assistanceTicket->creator_user_id == $user->id) { ?>
                                                        <img class="circle circleSmall m-0 " src="<?= $assistanceTicket->receiver->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->receiver->First()->firstname?>">
                                                        <p class="col-sm-9"><?= $assistanceTicket->receiver->First()->getName()?></p>
                                                    <? } else { ?>
                                                        <img class="circle circleSmall m-0 " src="<?= $assistanceTicket->creator->First()->getProfilePicture()?>" alt="<?= $assistanceTicket->creator->First()->firstname?>">
                                                        <p class="col-sm-9"><?= $assistanceTicket->creator->First()->getName()?></p>
                                                    <? } ?>
                                                </div>
                                                <div class="col-sm-3 m-t-10">
                                                    <p class="f-18"><a class="regular-link" href="/my-team/workspace/short-term-planner/<?= $assistanceTicket->task->short_term_planner_board_id?>?task_id=<?= $assistanceTicket->task_id?>"><?= $assistanceTicket->title?></a></p>
                                                </div>
                                                <div class="col-sm-2 m-r-20">
                                                    <p class="c-orange m-t-5">Completed</p>
                                                </div>
                                            </div>
                                            <div class="modal-body ">
                                                <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">
                                                    <? foreach($assistanceTicket->getMessages() as $message) { ?>
                                                        <? if($message->sender_user_id == $user->id) { ?>
                                                        <div class="row c-gray sendedMessageAjax">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-5 messageSent pull-right m-b-10">
                                                                    <p class="message break-word"><?= $message->message?></p>
                                                                    <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <? } else { ?>
                                                        <div class="row c-gray">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                    <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                                                                    <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - Team leader:</p>
                                                                    <? } else { ?>
                                                                    <p class="c-orange m-0"><?= $message->sender->First()->getName()?></p>
                                                                    <? } ?>
                                                                    <p class="break-word"><?= $message->message?></p>
                                                                    <span class="f-12 pull-right"><?=$message->time_sent?></span>
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
                        <? } else { ?>
                            <div class="completedAssistanceTicket" data-ticket-id="<?= $assistanceTicket->id?>">
                                <div class="card">
                                    <div class="card-block">
                                        <span class="removeAssistanceTicket" data-ticket-id="<?= $assistanceTicket->id?>"><i class="zmdi zmdi-close pull-right c-orange m-t-5 m-r-10"></i></span>
                                        <div class="text-center">
                                            <p class="f-18 m-t-10 m-l-20">Task: <?= $assistanceTicket->title?></p>
                                            <hr class="col-sm-9">
                                            <div class="row m-t-20">
                                                <div class="col-sm-12 d-flex fd-row js-center">
                                                    <div class="circle circleSmall"><i class="zmdi zmdi-eye-off f-10"></i></div>
                                                    <p class="m-l-20">User doesn't exist anymore</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <button class="btn btn-inno btn-sm m-b-20">Open</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade completedAssistanceModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header col-sm-12 d-flex">
                                                <div class="col-sm-4 d-flex m-t-30">
                                                    <div class="circle circleImage"><i class="zmdi zmdi-eye-off f-25"></i></div>
                                                    <p class="col-sm-12 f-14">User doesn't exist anymore</p>
                                                </div>
                                                <div class="col-sm-3 m-t-10">
                                                    <p class="f-18"><a class="regular-link" href="/my-team/workspace/short-term-planner/<?= $assistanceTicket->task->short_term_planner_board_id?>?task_id=<?= $assistanceTicket->task_id?>"><?= $assistanceTicket->title?></a></p>
                                                </div>
                                                <div class="col-sm-2 m-r-20">
                                                    <p class="c-orange m-t-5">Completed</p>
                                                </div>
                                            </div>
                                            <div class="modal-body ">
                                                <div class="o-scroll m-t-20 receivedAssistanceMessages" style="height: 400px;" data-ticket-id="<?= $assistanceTicket->id?>">
                                                    <? foreach($assistanceTicket->getMessages() as $message) { ?>
                                                        <? if($message->sender_user_id == $user->id) { ?>
                                                            <div class="row c-gray sendedMessageAjax">
                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-5 messageSent pull-right m-b-10">
                                                                        <p class="message break-word"><?= $message->message?></p>
                                                                        <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <? } else { ?>
                                                            <div class="row c-gray">
                                                                <div class="col-sm-12">
                                                                    <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                                                        <p class="c-orange m-0">User doesn't exist anymore</p>
                                                                        <p class="break-word"><?= $message->message?></p>
                                                                        <span class="f-12 pull-right"><?=$message->time_sent?></span>
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
                        <? } ?>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceAssistanceTickets.js"></script>
@endsection