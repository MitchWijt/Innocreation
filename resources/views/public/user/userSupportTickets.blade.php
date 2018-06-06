@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Support tickets</h1>
            </div>
            <div class="hr col-md-10 p-b-20"></div>
            <? if(count($supportTickets) > 0) { ?>
            <div class="row d-flex js-center">
                <div class="col-md-7 m-t-10">
                    <button class="btn btn-inno btn-sm" data-toggle="modal" data-target=".createSupportTicketModal">I have a question</button>
                    <button class="btn btn-inno btn-sm pull-right filterSupportTicketsMenuToggle"><i class="zmdi zmdi-settings"></i> Filter</button>
                </div>
            </div>
            <div class="row filterSupportTicketsMenu hidden">
                <div class="col-md-10 m-l-5">
                    <div class="pull-right c-gray text-center">
                        <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterSupportTickets" data-filter="Open">Open tickets</p>
                        <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterSupportTickets" data-filter="OnHold">Tickets on hold</p>
                        <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterSupportTickets" data-filter="Closed">Closed tickets</p>
                        <p class="bcg-black border-default m-b-0 menu-item filterSupportTickets" data-filter="All">All tickets</p>
                    </div>
                </div>
            </div>
            <? } else { ?>
                <div class="row d-flex js-center">
                    <div class="col-sm-12 m-t-10 d-flex js-center">
                        <button class="btn btn-inno btn-sm" data-toggle="modal" data-target=".createSupportTicketModal">I have a question</button>
                    </div>
                </div>
            <? } ?>
            <? foreach($supportTickets as $supportTicket) { ?>
                <div class="row m-t-20 singleSupportTicket d-flex js-center m-b-20">
                    <input type="hidden" class="ticketStatus" value="<?= $supportTicket->support_ticket_status_id?>">
                        <div class="supportTicket col-md-7">
                            <div class="card">
                                <div class="card-block supportTicketCard" data-ticket-id="<?= $supportTicket->id?>">
                                    <div class="row text-center js-center m-t-10">
                                        <div class="col-sm-12">
                                            <p class="f-18 m-b-0"><?= $supportTicket->title?></p>
                                        </div>
                                        <? if($supportTicket->helper_user_id != null) { ?>
                                            <? if($supportTicket->support_ticket_status_id == 1 || $supportTicket->support_ticket_status_id == 2) { ?>
                                                <p class="c-dark-grey m-b-0 f-12">Currently getting helped by <?= $supportTicket->helper->getName()?></p>
                                            <? } else { ?>
                                                <p class="c-dark-grey m-b-0 f-12">You have been helped by <?= $supportTicket->helper->getName()?></p>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                    <hr class="col-xs-10">
                                    <div class="row text-center m-t-10 d-flex js-center">
                                        <? if($supportTicket->support_ticket_status_id == 1) { ?>
                                            <p>Status: <span class="c-green"><?= $supportTicket->supportTicketStatus->status?></span></p>
                                        <? } else if($supportTicket->support_ticket_status_id == 2) { ?>
                                            <p>Status: <span class="c-orange"><?= $supportTicket->supportTicketStatus->status?></span></p>
                                        <? } else { ?>
                                            <p>Status: <span class="c-red"><?= $supportTicket->supportTicketStatus->status?></span></p>
                                        <? } ?>
                                    </div>
                                    <div class="row text-center d-flex js-center m-b-20">
                                        <?
                                        if($supportTicket->support_ticket_status_id == 3) {
                                            $today = date("Y-m-d");
                                            $closedDate = date("Y-m-d", strtotime($supportTicket->closed_at . "1 day"));
                                        ?>
                                            <? if($today >= $closedDate) { ?>
                                                <? if($user->checkCustomerServiceReview($supportTicket->id) == false) { ?>
                                                    <button class="btn btn-inno btn-sm" data-ticket-id="<?= $supportTicket->id?>">Rate this ticket!</button>
                                                <? } else {  ?>
                                                    <button class="btn btn-inno btn-sm" data-ticket-id="<?= $supportTicket->id?>">Reviewed</button>
                                                <? } ?>
                                        <? } else { ?>
                                            <button class="btn btn-inno btn-sm" data-ticket-id="<?= $supportTicket->id?>">Open ticket</button>
                                        <? } ?>
                                        <? } else { ?>
                                            <button class="btn btn-inno btn-sm" data-ticket-id="<?= $supportTicket->id?>">Open ticket</button>
                                        <? } ?>
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
                                                <?
                                                $today = date("Y-m-d");
                                                $closedDate = date("Y-m-d", strtotime($supportTicket->closed_at . " 1 day"));
                                                ?>
                                                <? if(strtotime($today) >= strtotime($closedDate)) { ?>
                                                    <? if($user->checkCustomerServiceReview($supportTicket->id) == false) { ?>
                                                        <form action="/user/rateSupportTicket" method="post">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" class="ticket_id" name="ticket_id" value="<?=$supportTicket->id?>">
                                                            <input type="hidden" class="user_id" name="user_id" value="<?=$user->id?>">
                                                            <div class="row m-t-20 m-l-50">
                                                                <div class="col-sm-9">
                                                                    <p class="m-b-5">Your experience with our customer support:</p>
                                                                    <select name="review" class="input col-sm-4">
                                                                        <option value="Great">Great</option>
                                                                        <option value="Good">Good</option>
                                                                        <option value="Medium">Medium</option>
                                                                        <option value="Bad">Bad</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input type="number" max="10" min="1" name="rating" class="input col-sm-4 m-r-0 p-r-0"><span> / 10</span>
                                                                </div>
                                                            </div>
                                                            <div class="row m-t-20">
                                                                <div class="col-sm-12 text-center">
                                                                    <textarea name="reviewDetails" placeholder="Tell us a little more about your experience" class="input col-sm-10" rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-11 m-b-20 m-t-20">
                                                                    <button type="submit" class="btn btn-inno pull-right">Submit rating</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <? } else { ?>
                                                        <div class="col-sm-12 text-center">
                                                            <p>Thank you for reviewing this support ticket! your support is well appreciated</p>
                                                        </div>
                                                    <? } ?>
                                                <? } else { ?>
                                                    <div class="row">
                                                        <div class="col-sm-12 text-center">
                                                            <p>This ticket has been closed. We hope we have been able to help you well!</p>
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
            <div class="modal fade createSupportTicketModal" id="createSupportTicketModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header col-sm-12 d-flex js-center">
                            <p class="m-t-10 f-18 m-b-0">Feel free to ask us anything</p>
                        </div>
                        <div class="modal-body ">
                            <form action="/user/addSupportTicket" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<?= $user->id?>">
                                <div class="row m-b-20">
                                    <div class="col-sm-12">
                                        <input type="text" name="supportTicketTitle" placeholder="Subject of your question" class="input col-sm-4">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <textarea name="supportTicketQuestion" class="input col-sm-12" placeholder="Describe your question" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-9">
                                            <ul class="instructions-list">
                                                <li class="instructions-list-item"><span class="c-black">Describe your question as clear as possible </span></li>
                                                <li class="instructions-list-item"><span class="c-black">You will be helped asap by one of our staff members</span></li>
                                                <li class="instructions-list-item"><span class="c-black">Before using tickets, please take a look at the FAQ</span></li>
                                                <li class="instructions-list-item"><span class="c-black">We hope we can help you with all your problems</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-inno pull-right">Ask my question</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/user/userSupportTickets.js"></script>
@endsection