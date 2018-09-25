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
                                <h4 class="m-t-5">User accounts</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col" data-column-id="name">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Team leader</th>
                                        <th scope="col">Team</th>
                                        <th scope="col">Country</th>
                                        <th scope="col" data-formatter="date">Joined at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($users as $user) { ?>
                                        <tr class="clickable-row" data-href="/admin/user/<? echo $user->id?>">
                                            <td scope="row" data-visible="false"><?= $user->id?></td>
                                            <td><?= $user->getName()?></td>
                                            <td><?= $user->email?></td>
                                            <? if($user->team_id != null) { ?>
                                                <? if($user->team->ceo_user_id == $user->id) { ?>
                                                    <td><i class="zmdi zmdi-check f-20 c-orange"></i></td>
                                                <? } else { ?>
                                                    <td> - </td>
                                                <? } ?>
                                            <? } else { ?>
                                                <td> - </td>
                                            <? } ?>
                                            <? if($user->team_id != null) { ?>
                                                <td><?= $user->team->team_name?></td>
                                            <? } else { ?>
                                                <td> - </td>
                                            <? } ?>
                                            <? if($user->country_id != null) { ?>
                                                <td><?= $user->country->country?></td>
                                            <? } else { ?>
                                                <td> - </td>
                                            <? } ?>
                                            <td><?= date("d-m-Y",strtotime($user->created_at))?></td>
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