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
                                <h4 class="m-t-5">Support tickets</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 d-flex m-t-20">
                                <div class="col-sm-3">

                                </div>
                                <div class="col-sm-2">
                                    <span>Name</span>
                                </div>
                                <div class="col-sm-2">
                                    <span>Status</span>
                                </div>
                                <div class="col-sm-2">
                                    <span>Helper</span>
                                </div>
                                <div class="col-sm-3">

                                </div>
                            </div>
                            <div class="hr col-sm-11 m-b-15"></div>
                            <? foreach($supportTickets as $supportTicket) { ?>
                                <? if($supportTicket->users) { ?>
                                    <div class="supportTicket col-sm-12" data-ticket-id="<?= $supportTicket->id?>">
                                        <div class="d-flex m-b-5">
                                            <div class="col-sm-3 text-center">
                                                <img class="circle circleSmall" src="<?= $supportTicket->users->getProfilePicture()?>" alt="">
                                            </div>
                                            <div class="col-sm-2">
                                                <p><?= $supportTicket->users->getName()?></p>
                                            </div>
                                            <div class="col-sm-2">
                                                <? if($supportTicket->support_ticket_status_id == 1) { ?>
                                                    <p class="c-green status"><?= $supportTicket->supportTicketStatus->status?></p>
                                                <? } else if($supportTicket->support_ticket_status_id == 2) { ?>
                                                    <p class="c-orange status"><?= $supportTicket->supportTicketStatus->status?></p>
                                                <? } else { ?>
                                                    <p class="c-red status"><?= $supportTicket->supportTicketStatus->status?></p>
                                                <? } ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <p><? if($supportTicket->helper_user_id != null) echo $supportTicket->helper->getName(); else echo "No helper yet"?></p>
                                            </div>
                                            <div class="col-sm-3">
                                                <button class=" btn btn-inno btn-sm openModalTicket" data-ticket-id="<?= $supportTicket->id?>">Open ticket</button>
                                            </div>
                                        </div>
                                        <!-- MODAL TICKET -->
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header col-sm-12 d-flex">
                                                        <div class="col-sm-3">
                                                            <select name="supportTicketStatus" class="input m-t-5 supportTicketStatus" >
                                                                <? foreach($supportTicketStatusses as $supportTicketStatus) { ?>
                                                                    <option <? if($supportTicketStatus->id == $supportTicket->support_ticket_status_id) echo "selected";?> value="<?= $supportTicketStatus->id?>" data-ticket-id="<?= $supportTicket->id?>"><?= $supportTicketStatus->status?></option>
                                                                <? } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="d-flex fd-column">
                                                                <p class="f-20 modal-title text-center c-black" id="modalLabel"><?= $supportTicket->title?></p>
                                                                <small class="c-black text-center"><?= $supportTicket->users->getName()?></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="col-sm-12 d-flex fd-column">
                                                                <? if($supportTicket->support_ticket_status_id == 3) { ?>
                                                                    <div class="col-sm-12">
                                                                        <p class="c-black m-b-5 f-14">Helped by: <?= $supportTicket->helper->getName()?></p>
                                                                    </div>
                                                                <? } else { ?>
                                                                    <div class="col-sm-12">
                                                                    <? if($supportTicket->helper_user_id != null) { ?>
                                                                        <p class="c-black m-b-5">Helper: <?= $supportTicket->helper->getName()?></p>
                                                                    <? } ?>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <form action="/admin/assignHelperToSupportTicket" method="post">
                                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                            <input type="hidden" name="user_id" value="<?= $admin->id?>">
                                                                            <input type="hidden" name="support_ticket_id" value="<?= $supportTicket->id?>">
                                                                            <button class="btn btn-inno btn-sm col-sm-12">Assign me</button>
                                                                        </form>
                                                                    </div>
                                                                <? } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body ">
                                                        <div class="o-scroll m-t-20 supportTicketMessages" data-ticket-id="<?= $supportTicket->id?>" style="height: 400px;">

                                                        </div>
                                                        <div class="d-flex js-center">
                                                            <hr class="col-sm-12 m-b-20">
                                                        </div>
                                                        <? if($supportTicket->helper_user_id != null && $supportTicket->helper_user_id == $admin->id) { ?>
                                                            <? if($supportTicket->support_ticket_status_id == 1 || $supportTicket->support_ticket_status_id == 2) { ?>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                    <input type="hidden" class="ticket_id" name="ticket_id" value="<?=$supportTicket->id?>">
                                                                    <input type="hidden" class="sender_user_id" name="sender_user_id" value="<?=$admin->id?>">
                                                                    <div class="row m-t-20">
                                                                        <div class="col-sm-12 text-center">
                                                                            <textarea name="supportTicketMessage" class="input col-sm-10 supportTicketMessage" rows="5">Hello <?= $supportTicket->users->firstname?>,
    Best regards <?= $admin->getName()?> - Innocreation</textarea>
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
                                                                    <div class="col-sm-12 text-center c-black">
                                                                        <p>This ticket has been closed.</p>
                                                                    </div>
                                                                </div>
                                                            <? } ?>
                                                        <? } else { ?>
                                                            <div class="row">
                                                                <div class="col-sm-12 text-center c-black">
                                                                    <p>Helper is not assigned. Or you are not the helper</p>
                                                                </div>
                                                            </div>
                                                        <? } ?>
                                                    </div>
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
    <script>
        $(".openModalTicket").on("click",function () {
            $(this).parents(".supportTicket").find(".modal").modal().toggle();
        });

        $(".supportTicketStatus").on("change",function () {
            var status_id = $(this).parents(".supportTicket").find(".supportTicketStatus option:selected").val();
            var ticket_id = $(this).parents(".supportTicket").find(".supportTicketStatus option:selected").data("ticket-id");
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/admin/changeStatusSupportTicket",
                data: {'status_id': status_id, "ticket_id" : ticket_id},
                success: function (data) {
                    $(".supportTicket").each(function () {
                        console.log("fds");
                       if($(this).data("ticket-id") == ticket_id){
                           $(this).find(".status").removeClass("c-green");
                           $(this).find(".status").removeClass("c-orange");
                           $(this).find(".status").removeClass("c-red");
                           if(data == "Open"){
                               $(this).find(".status").addClass("c-green");
                           } else if(data == "On hold"){
                               $(this).find(".status").addClass("c-orange");
                           } else {
                               $(this).find(".status").addClass("c-red");
                           }
                           $(this).find(".status").text(data);
                       }
                    });
                }
            });
        });

        $(".openModalTicket").on("click",function () {
            var ticket_id = $(this).data("ticket-id");
            var admin = 1;
            function getSupportTicketMessages() {
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/message/getSupportTicketMessages",
                    data: {'ticket_id': ticket_id, 'admin' : admin},
                    success: function (data) {
                        $(".supportTicket").each(function () {
                            if($(this).data("ticket-id") == ticket_id){
                                $(this).find(".supportTicketMessages").html(data);
                            }
                        });
                    }
                });
            }
            setTimeout(function(){
                getSupportTicketMessages();
            }, 300);
            setTimeout(function(){
                var objDiv = $(".supportTicketMessages");
                if (objDiv.length > 0){
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }, 500);
            setInterval(function () {
                getSupportTicketMessages();
            }, 20000);
            $(this).parents(".supportTicket").find(".supportTicketModal").modal().toggle();
        });

        $(".sendSupportTicketMessage").on("click",function () {
            var ticket_id = $(this).parents(".supportTicket").find(".ticket_id").val();
            var sender_user_id = $(this).parents(".supportTicket").find(".sender_user_id").val();
            var message = $(this).parents(".supportTicket").find(".supportTicketMessage").val();
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/user/sendSupportTicketMessage",
                data: {'ticket_id': ticket_id, 'sender_user_id' : sender_user_id, 'message' : message},
                dataType: "JSON",
                success: function (data) {
                    var message = $('.sendedMessageAjax').first().clone();
                    $(".supportTicketMessages").each(function () {
                        if($(this).data("ticket-id") == ticket_id){
                            var allMessages = $(this);
                            $(message).appendTo(allMessages);
                            message.find(".message").text(data['message']);
                            message.find(".timeSent").text(data['timeSent']);
                            $(this).parents(".supportTicket").find(".supportTicketMessage").val("");
                            setTimeout(function(){
                                var objDiv = $(".supportTicketMessages");
                                if (objDiv.length > 0){
                                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                                }
                            }, 1);
                        }
                    });
                }
            });
        });
    </script>
@endsection