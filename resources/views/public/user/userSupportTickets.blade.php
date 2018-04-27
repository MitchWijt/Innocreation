@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Support tickets</h1>
            </div>
            <div class="hr"></div>
            <div class="row d-flex js-center">
                <div class="col-sm-7 m-t-10">
                    <button class="btn btn-inno btn-sm">I have a question</button>
                    <button class="btn btn-inno btn-sm pull-right"><i class="zmdi zmdi-settings"></i> Filter</button>
                </div>
            </div>
            <? foreach($supportTickets as $supportTicket) { ?>
                <div class="row m-t-20">
                    <div class="col-sm-12 d-flex js-center m-b-20">
                        <div class="supportTicket">
                            <div class="card">
                                <div class="card-block supportTicketCard" data-ticket-id="<?= $supportTicket->id?>">
                                    <div class="row">
                                        <div class="col-sm-12 text-center m-t-10">
                                            <p class="f-18 m-b-0"><?= $supportTicket->title?></p>
                                            <? if($supportTicket->helper_user_id != null) { ?>
                                                <? if($supportTicket->support_ticket_status_id == 1 || $supportTicket->support_ticket_status_id == 2) { ?>
                                                    <p class="c-dark-grey m-b-0 f-12">Currently getting helped by <?= $supportTicket->helper->getName()?></p>
                                                <? } else { ?>
                                                    <p class="c-dark-grey m-b-0 f-12">You have been helped by <?= $supportTicket->helper->getName()?></p>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <hr class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-12 text-center m-t-10">
                                            <? if($supportTicket->support_ticket_status_id == 1) { ?>
                                                <p>Status: <span class="c-green"><?= $supportTicket->supportTicketStatus->status?></span></p>
                                            <? } else if($supportTicket->support_ticket_status_id == 2) { ?>
                                                <p>Status: <span class="c-orange"><?= $supportTicket->supportTicketStatus->status?></span></p>
                                            <? } else { ?>
                                                <p>Status: <span class="c-red"><?= $supportTicket->supportTicketStatus->status?></span></p>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center m-b-20">
                                            <button class="btn btn-inno btn-sm" data-ticket-id="<?= $supportTicket->id?>">Open ticket</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade supportTicketModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-ticket-id="<?= $supportTicket->id?>">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header col-sm-12 js-center fd-column">
                                            <p class="m-t-10 f-18 m-b-0"><?= $supportTicket->title?></p>
                                            <? if($supportTicket->support_ticket_status_id == 1) { ?>
                                                <small class="c-green"><?= $supportTicket->supportTicketStatus->status?></small>
                                            <? } else if($supportTicket->support_ticket_status_id == 2) { ?>
                                                <small class="c-orange"><?= $supportTicket->supportTicketStatus->status?></small>
                                            <? } else { ?>
                                                <small class="c-red"><?= $supportTicket->supportTicketStatus->status?></small>
                                            <? } ?>
                                            <? if($supportTicket->helper_user_id != null) { ?>
                                                <? if($supportTicket->support_ticket_status_id == 1 || $supportTicket->support_ticket_status_id == 2) { ?>
                                                    <p class="c-dark-grey m-b-0">Currently getting helped by <?= $supportTicket->helper->getName()?></p>
                                                <? } else { ?>
                                                    <p class="c-dark-grey m-b-0">You have been helped by <?= $supportTicket->helper->getName()?></p>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                        <div class="modal-body ">
                                            <div class="o-scroll m-t-20 supportTicketMessages" data-ticket-id="<?= $supportTicket->id?>" style="height: 400px;">

                                            </div>
                                            <div class="d-flex js-center">
                                                <hr class="col-sm-12 m-b-20">
                                            </div>
                                            <? if($supportTicket->support_ticket_status_id == 1 || $supportTicket->support_ticket_status_id == 2) { ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" class="ticket_id" name="ticket_id" value="<?=$supportTicket->id?>">
                                                <input type="hidden" class="sender_user_id" name="sender_user_id" value="<?=$user->id?>">
                                                <div class="row m-t-20">
                                                    <div class="col-sm-12 text-center">
                                                        <textarea name="supportTicketMessage" placeholder="Send your message..." class="input col-sm-10 supportTicketMessage" rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-11 m-b-20 m-t-20">
                                                        <button type="button" class="btn btn-inno pull-right sendSupportTicketMessage">Send message</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <? } else { ?>
                                                <div class="row">
                                                    <div class="col-sm-12 text-center">
                                                        <p>This ticket has been closed. We hope we have been able to help you well!</p>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/user/userSupportTickets.js"></script>
@endsection