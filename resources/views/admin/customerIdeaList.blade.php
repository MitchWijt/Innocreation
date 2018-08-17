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
            <div class="row d-flex js-center">
                <div class="col-md-10">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row">
                                <div class="col-sm-12 m-l-20">
                                    <h3 class="f-20">Submitted ideas</h3>
                                </div>
                                <div class="hr col-md-11"></div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-4 text-center">
                                        <span class="f-13">Title</span>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <span class="f-13">Idea</span>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <span class="f-13">Status</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-card p-b-20"></div>
                            <? foreach($customerIdeas as $customerIdea) { ?>
                                <div class="row customerIdea">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-4 text-center">
                                            <p><?= $customerIdea->title?></p>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <p><?= $customerIdea->idea?></p>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <select name="status" class="changeIdeaStatus input <? if($customerIdea->customer_idea_status_id == 1) echo "c-orange"; else if($customerIdea->customer_idea_status_id == 2) echo "c-green"; else echo "c-red"?>">
                                                <? foreach($customerIdeaStatusses as $customerIdeaStatus) { ?>
                                                    <option data-idea-id="<?= $customerIdea->id?>" value="<?= $customerIdeaStatus->id?>" <? if($customerIdea->customer_idea_status_id == $customerIdeaStatus->id) echo "selected"?>><?= $customerIdeaStatus->title?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade rejectIdeaModal" id="rejectIdeaModal" tabindex="-1" role="dialog" aria-labelledby="rejectIdeaModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <form action="/admin/changeStatusCustomerIdea" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" class="status" name="status" value="">
                                <input type="hidden" class="idea_id" name="idea_id" value="">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="m-b-5">Reason to reject idea</p>
                                        <textarea name="message" class="col-sm-12 input" cols="30" rows="5" placeholder="description"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-inno pull-right">Reject idea</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".changeIdeaStatus").on("change",function () {
            var idea_id = $(this).parents(".customerIdea").find(".changeIdeaStatus option:selected").data("idea-id");
            var statusId = $(this).parents(".customerIdea").find(".changeIdeaStatus option:selected").val();
            $(this).removeClass("c-green");
            $(this).removeClass("c-red");
            $(this).removeClass("c-orange");
            if(statusId == 1){
                $(this).addClass("c-orange");
            } else if(statusId == 2){
                $(this).addClass("c-green");
            } else {
                $(this).addClass("c-red");
            }
            if(statusId == 1 || statusId == 2){
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/admin/changeStatusCustomerIdea",
                    data: {'idea_id': idea_id, 'status': statusId},
                    success: function (data) {

                    }
                });
            } else {
                $(".status").val(statusId);
                $(".idea_id").val(idea_id);
                $(".rejectIdeaModal").modal().toggle();
            }
        });
    </script>
@endsection