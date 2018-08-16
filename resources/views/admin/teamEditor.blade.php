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
                            <form action="/admin/deleteTeamProfilePicture" method="post" class="profilePictureForm">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="team_id" value="<? if(isset($team)) echo $team->id ?>">
                            </form>
                            <form action="/admin/saveTeam" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="team_id" value="<? if(isset($team)) echo $team->id ?>">
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
                                            <th scope="col">Paid split the bill</th>
                                            <th scope="col">Expertise</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($team->getMembers() as $member) { ?>
                                            <tr class="clickable-row" data-href="/admin/user/<? echo $member->id?>">
                                                <td scope="row" data-visible="false"><?= $member->id?></td>
                                                <td><?= $member->getName()?></td>
                                                <td><?= $member->roles->First()->title?></td>
                                                <? if($team->split_the_bill == 1) { ?>
                                                    <? if($member->paidSplitTheBill()) { ?>
                                                        <td><i class="zmdi zmdi-check c-orange f-20"></i></td>
                                                    <? } else { ?>
                                                        <td><i class="zmdi zmdi-close c-orange f-20"></i></td>
                                                    <? } ?>
                                                <? } else { ?>
                                                    <td> - </td>
                                                <? } ?>
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
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between m-b-10">
                                <h4 class="m-t-5">Team chat</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-t-20">
                                <form action="/admin/sendMessageTeamChat" method="post" class="m-b-20">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="team_id" value="<?= $team->id?>">
                                    <textarea name="message_team_chat" class="input col-sm-12" cols="30" rows="6">Hello <?= $team->team_name?>,
Best regards <?= $admin->getName()?> - Innocreation</textarea>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-inno pull-right">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20 m-b-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between m-b-10">
                                <h4 class="m-t-5">Needed expertises</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-t-20">
                                <? foreach($team->getNeededExpertises() as $neededExpertise) { ?>
                                    <div class="m-b-20">
                                        <form action="/admin/saveNeededExpertiseBackend" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="needed_expertise_id" value="<?= $neededExpertise->id?>">
                                            <p class="f-20 underline"><?= $neededExpertise->Expertises->First()->title?></p>
                                            <div class="col-sm-12 d-flex">
                                                <p class="f-13 col-sm-6 m-b-5 p-0">Description:</p>
                                                <p class="f-13 col-sm-6 m-b-5 m-l-10">Requirements:</p>
                                            </div>
                                            <div class="col-sm-12 d-flex">
                                                <textarea name="description_needed_expertise" class="input col-sm-6 m-r-20" cols="30" rows="6"><? if(isset($neededExpertise->description)) echo $neededExpertise->description?></textarea>
                                                <textarea name="requirements_needed_expertise" class="input col-sm-6 pull" cols="30" rows="6"><? if(isset($neededExpertise->requirements)) echo $neededExpertise->requirements?></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="f-13 col-sm-6 m-b-5 p-0">Amount:</p>
                                                <input type="number" name="amount" class="input" value="<?= $neededExpertise->amount?>">
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 m-t-10">
                                                    <button class="btn btn-inno pull-right">Save <?= $neededExpertise->Expertises->First()->title?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20 m-b-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between m-b-10">
                                <h4 class="m-t-5">Payments</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-t-20">
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
        });

        $(".deleteProfilePicture").on("click",function () {
            if(confirm("Are you sure you want to delete this profile picture?")) {
                $(".profilePictureForm").submit();
            }
        });
    </script>
@endsection