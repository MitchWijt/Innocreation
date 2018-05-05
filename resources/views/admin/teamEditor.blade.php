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
                            <div class="col-sm-12 d-flex js-between m-b-10">
                                <h4 class="m-t-5"><?= $team->team_name?></h4>
                                <div class="buttons m-t-5">
                                    <a target="_blank" href="<?= $team->getUrl()?>" class="btn btn-inno pull-right btn-sm m-r-10">To live page</a>
                                </div>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <form action="/admin/saveTeam" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<? if(isset($team)) echo $team->id ?>">
                                <div class="row">
                                    <div class="col-sm-12 d-flex m-b-20">
                                        <div class="col-sm-5">
                                            <div class="col-sm-12 m-t-15 m-b-20">
                                                <i class="zmdi zmdi-close c-orange pull-right f-20 p-absolute deleteProfilePicture" style="right: 240px;"></i>
                                                <img  src="<?= $team->getProfilePicture()?>" class="circle circleMedium m-0">
                                                <p class="m-t-10 m-l-30">Team leader:<br> <a target="_blank" class="regular-link" href="<?= $team->users->First()->getUrl()?>"><?= $team->users->First()->getName()?></a></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-12 d-flex m-t-20">
                                                    <div class="col-sm-6">
                                                        <label for="">Motivation:</label>
                                                        <textarea name="team_motivation" class="input col-sm-12" cols="30" rows="6"><? if($team->team_motivation) echo $team->team_motivation?></textarea>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="">Introduction</label>
                                                        <textarea name="team_introduction" class="input col-sm-12" cols="30" rows="6"><? if($team->team_introduction) echo $team->team_introduction?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-inno pull-right m-r-15">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between m-b-10">
                                <h4 class="m-t-5">Members of <?= $team->team_name?></h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-t-20">
                                <table  id="table" class="display">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                            <th scope="col" data-column-id="name">Name</th>
                                            <th scope="col">team role</th>
                                            <th scope="col">Expertise</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($team->getMembers() as $member) { ?>
                                            <tr class="clickable-row" data-href="/admin/user/<? echo $member->id?>">
                                                <td scope="row" data-visible="false"><?= $member->id?></td>
                                                <td><?= $member->getName()?></td>
                                                <td><?= $member->roles->First()->title?></td>
                                                <? if($team->ceo_user_id == $member->id) { ?>
                                                    <td>Team leader</td>
                                                <? } else { ?>
                                                    <td><?= $member->getJoinedExpertise()->expertises->First()->title?></td>
                                                <? } ?>
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