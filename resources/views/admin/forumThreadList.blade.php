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
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Forum threads</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col" data-column-id="name">Creator</th>
                                        <th scope="col">Closed</th>
                                        <th scope="col">Main topic</th>
                                        <th scope="col" data-formatter="date">Posted at</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($forumThreads as $forumThread) { ?>
                                        <tr class="threadTable">
                                            <td scope="row" data-visible="false"><?= $forumThread->id?></td>
                                            <td><?= $forumThread->title?></td>
                                            <td><?= $forumThread->creator->getName()?></td>
                                            <td>
                                                <? if($forumThread->closed == 1) { ?>
                                                    <i class="zmdi zmdi-check c-orange f-20"></i>
                                                <? } else { ?>
                                                    <i></i>
                                                <? } ?>
                                            </td>
                                            <td><?= $forumThread->forumMainTopic->First()->title?></td>
                                            <td><?= date("d-m-Y",strtotime($forumThread->created_at))?></td>
                                            <td>
                                                <form action="/admin/deleteForumThread" method="post" class="deleteThreadForm">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="forum_thread_id" value="<?= $forumThread->id?>">
                                                    <button class="btn btn-inno deleteThreadBtn" type="button">Delete thread</button>
                                                </form>
                                            </td>
                                            <td>
                                                <? if($forumThread->closed == 0) { ?>
                                                    <form action="/admin/closeForumThread" method="post">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="forum_thread_id" value="<?= $forumThread->id?>">
                                                        <button class="btn btn-inno">Close thread</button>
                                                    </form>
                                                <? } else { ?>
                                                    <form action="/admin/openForumThread" method="post">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="forum_thread_id" value="<?= $forumThread->id?>">
                                                        <button class="btn btn-inno">Open thread</button>
                                                    </form>
                                                <? } ?>
                                            </td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );

        $(".deleteThreadBtn").on("click",function () {
           if(confirm("Are you sure you want to delete this thread?")){
              $(this).parents(".threadTable").find(".deleteThreadForm").submit();
           }
        });
    </script>
@endsection