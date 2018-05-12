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
                                <h4 class="m-t-5">Faqs</h4>
                                <a target="_blank" href="/admin/faqEditor" class="btn btn-inno m-t-5 m-b-10">Add question</a>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">Question</th>
                                        <th scope="col" data-column-id="name">Answer</th>
                                        <th scope="col" data-column-id="name">Category</th>
                                        <th scope="col">published</th>
                                        <th scope="col" data-formatter="date">Created at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($faqs as $faq) { ?>
                                            <tr class="clickable-row" data-href="/admin/faqEditor/<? echo $faq->id?>">
                                                <td scope="row" data-visible="false"><?= $faq->id?></td>
                                                <td><?= $faq->question?></td>
                                                <td><?= $faq->answer?></td>
                                                <td><?= $faq->faqType->title?></td>
                                                <td>
                                                    <? if($faq->published == 1) { ?>
                                                        <i class="zmdi zmdi-check c-orange f-20"></i>
                                                    <? } else { ?>
                                                        <i></i>
                                                    <? } ?>
                                                </td>
                                                <td><?= date("d-m-Y",strtotime($faq->created_at))?></td>
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