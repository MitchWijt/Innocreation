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
                                <h4 class="m-t-5">Teams</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col" data-column-id="name">Team name</th>
                                        <th scope="col">Amount members</th>
                                        <th scope="col">Membership</th>
                                        <th scope="col">Custom package</th>
                                        <th scope="col" data-formatter="date">Joined at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($teams as $team) { ?>
                                        <tr class="clickable-row" data-href="/admin/team/<? echo $team->id?>">
                                            <td scope="row" data-visible="false"><?= $team->id?></td>
                                            <td><?= $team->team_name?></td>
                                            <td><?= count($team->getMembers())?></td>
                                            <td><i class="zmdi zmdi-check c-orange f-20"></i></td>
                                            <td><i class="zmdi zmdi-check c-orange f-20"></i></td>
                                            <td><?= date("d-m-Y",strtotime($team->created_at))?></td>
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