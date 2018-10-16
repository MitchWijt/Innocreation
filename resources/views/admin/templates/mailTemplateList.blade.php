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
                                <h4 class="m-t-5">Mail templates</h4>
                                <a target="_blank" href="/admin/mailTemplateEditor" class="btn btn-inno m-t-5 m-b-10">Add template</a>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col" data-formatter="date">Created at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($mailTemplates as $mailTemplate) { ?>
                                        <tr class="clickable-row" data-href="/admin/mailTemplateEditor/<? echo $mailTemplate->id?>">
                                            <td scope="row" data-visible="false"><?= $mailTemplate->id?></td>
                                            <td><?= $mailTemplate->subject?></td>
                                            <td><?= date("d-m-Y",strtotime($mailTemplate->created_at))?></td>
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