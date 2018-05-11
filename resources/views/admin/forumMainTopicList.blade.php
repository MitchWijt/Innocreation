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
                                <h4 class="m-t-5">Teams</h4>
                                <a target="_blank" href="/admin/forumMainTopicEditor" class="btn btn-inno m-t-5 m-b-10">Create new topic</a>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col" data-column-id="name">Category</th>
                                        <th scope="col">published</th>
                                        <th scope="col" data-formatter="date">Created at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($forumMainTopics as $forumMainTopic) { ?>
                                    <tr class="clickable-row" data-href="/admin/forumMainTopicEditor/<? echo $forumMainTopic->id?>">
                                        <td scope="row" data-visible="false"><?= $forumMainTopic->id?></td>
                                        <td><?= $forumMainTopic->title?></td>
                                        <td><?= $forumMainTopic->type->title?></td>
                                        <td>
                                            <? if($forumMainTopic->published == 1) { ?>
                                                <i class="zmdi zmdi-check c-orange f-20"></i>
                                            <? } else { ?>
                                                <i class="zmdi zmdi-close c-orange f-20"></i>
                                            <? } ?>
                                        </td>
                                        <td><?= date("d-m-Y",strtotime($forumMainTopic->created_at))?></td>
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
        $(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });

        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
@endsection