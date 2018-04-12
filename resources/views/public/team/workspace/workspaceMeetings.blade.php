@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Meetings <?= strtolower($team->team_name)?></h1>
            </div>
            <hr class="m-b-20">
            @if(session('success'))
                <div class="alert alert-success m-b-20 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12 ">
                    <button class="btn btn-inno btn-sm" data-toggle="modal" data-target="#planNewMeeting">Plan new meeting</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="col-sm-12 d-flex">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade planNewMeeting" id="planNewMeeting" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex js-center">
                    <h4 class="modal-title text-center" id="modalLabel">Plan new meeting</h4>
                </div>
                <div class="modal-body">
                    <form action="/workspace/addNewMeeting" method="post" class="meetingForm">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" name="meetingObjective" class="input col-sm-5" placeholder="Objective meeting:">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="descriptionMeeting" class="input col-sm-10 m-t-20" placeholder="Meeting description" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" name="dateMeeting" class="input col-sm-5 dateMeeting m-t-15" placeholder="Date of meeting:">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" name="timeMeeting" class="input col-sm-5 timeMeeting m-t-15" placeholder="Time of meeting:">
                            </div>
                        </div>
                        <p class="m-t-15 m-b-5 f-18 m-b-5">Max duration:</p>
                        <div class="row m-b-10">
                            <div class="col-sm-5 d-flex fd-row">
                                <span class="m-r-10">Hours:</span>
                                <div class="row">
                                    <div class="col-sm-12 d-flex ">
                                        <input type="number" name="hours" max="24" min="0" class="input" value="1">
                                    </div>
                                </div>
                                <span class="m-l-10 m-r-10">Minutes:</span>
                                <div class="row">
                                    <div class="col-sm-12 d-flex ">
                                        <input type="number" name="minutes" max="59" min="0" class="input" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row m-t-10">
                            <div class="col-sm-12 d-flex">
                                <div class="form-group col-sm-7 p-l-0">
                                    <select name="attendees" class="input col-sm-5 attendeeSelect">
                                        <option value="" selected disabled>Choose members</option>
                                        <option value="All_members" >Attend everyone</option>
                                        <? foreach($team->getMembers() as $member) { ?>
                                            <? if($member->id != $user->id) { ?>
                                                <? if($member->id == $team->ceo_user_id) { ?>
                                                    <option value="<?= $member->id?>"><?= $member->getName() . " - " . "CEO"?></option>
                                                <? } else { ?>
                                                <option value="<?= $member->id?>"><?= $member->getName() . " - " . $member->getJoinedExpertise()->expertises->First()->title?></option>
                                                <? } ?>
                                            <? } ?>
                                        <? } ?>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <ul class="addedAttendees">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-inno pull-right">Plan meeting</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceMeetings.js"></script>
@endsection