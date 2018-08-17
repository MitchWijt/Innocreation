@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between">
                                <h4 class="m-t-5">Sent mails</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">Receiver</th>
                                        <th scope="col" data-column-id="name">Subject</th>
                                        <th scope="col" data-formatter="date">Created at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($mailMessages as $mailMessage) { ?>
                                            <tr class="clickable-row" data-id="<?= $mailMessage->id?>">
                                                <td scope="row" data-visible="false"><?= $mailMessage->id?></td>
                                                <td><?= $mailMessage->users->email?></td>
                                                <td><?= $mailMessage->subject?></td>
                                                <td><?= date("d-m-Y H:i:s",strtotime($mailMessage->created_at))?></td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade mailMessageModal" id="mailMessageModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body modalData">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function($) {
            $(".clickable-row").click(function() {
                var mail_message_id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/admin/getMailMessageModalData",
                    data: {'mail_message_id': mail_message_id},
                    success: function (data) {
                       $(".modalData").html(data);
                       $(".mailMessageModal").modal().toggle();
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
@endsection