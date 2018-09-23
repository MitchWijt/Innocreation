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
                                <h4 class="m-t-5">Expertises</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col" data-column-id="name">Active users</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($expertises as $expertise) { ?>
                                        <tr class="clickable-row expertiseTable" data-href="/admin/expertise/<? echo $expertise->id?>">
                                            <td scope="row" data-visible="false"><?= $expertise->id?></td>
                                            <td><?= $expertise->title?></td>
                                            <td><?= count($expertise->getActiveUsers())?></td>
                                            <td>
                                                <form action="/admin/deleteExpertise" method="post" class="deleteExpertiseForm">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="expertise_id" value="<?= $expertise->id?>">
                                                    <button class="btn btn-inno deleteExpertiseBtn" type="button">Delete</button>
                                                </form>
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

        $(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });

        $(".deleteExpertiseBtn").on("click",function (e) {
            if(confirm("Are you sure you want to delete this expertise?")){
                $(this).parents(".expertiseTable").find(".deleteExpertiseForm").submit();
            }
            e.preventDefault();
            e.stopPropagation();
        });
    </script>
@endsection