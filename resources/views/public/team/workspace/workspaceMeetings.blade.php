@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.workspace_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.workspace_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-25 @endmobile">Meetings <?= strtolower($team->team_name)?></h1>
            </div>
            <hr class="m-b-20 col-xs-12">
            @if(session('success'))
                <div class="alert alert-success m-b-20 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <? if(!$team->packageDetails() || !$team->hasPaid()) { ?>
                        <? if(count($meetings) >= 2) { ?>
                            <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm">Plan new meeting</button>
                        <? } else { ?>
                            <button class="btn btn-inno btn-sm planMeetingModalToggle" data-toggle="modal" data-target="#planNewMeeting">Plan new meeting</button>
                        <? } ?>
                    <? } else { ?>
                        <? if($team->hasPaid()) { ?>
                            <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                                <? if($team->packageDetails()->membershipPackage->id == 3) { ?>
                                    <button class="btn btn-inno btn-sm planMeetingModalToggle" data-toggle="modal" data-target="#planNewMeeting">Plan new meeting</button>
                                <? } else if(count($meetings) >= $team->packageDetails()->membershipPackage->meetings) { ?>
                                    <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm">Plan new meeting</button>
                                <? } else { ?>
                                    <button class="btn btn-inno btn-sm planMeetingModalToggle" data-toggle="modal" data-target="#planNewMeeting">Plan new meeting</button>
                                <? } ?>
                            <? } else { ?>
                                <? if(count($meetings) >= $team->packageDetails()->customTeamPackage->meetings && $team->packageDetails()->customTeamPackage->meetings != "unlimited") { ?>
                                    <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm">Plan new meeting</button>
                                <? } else { ?>
                                    <button class="btn btn-inno btn-sm planMeetingModalToggle" data-toggle="modal" data-target="#planNewMeeting">Plan new meeting</button>
                                <? } ?>
                            <? } ?>
                        <? } else { ?>
                            <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm">Plan new meeting</button>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
            <? foreach($meetings as $meeting) { ?>
                <div class="meeting">
                    <div class="row m-t-20">
                        <div class="col-md-7 p-l-0">
                            <div class="card m-l-15">
                                <div class="card-block meetingCardToggle m-t-10" data-meeting-id="<?= $meeting->id?>">
                                    <div class="row pull-right">
                                        <i class="zmdi zmdi-edit f-20 c-orange editMeeting"></i>
                                        <i class="zmdi zmdi-close c-orange m-r-30 m-l-15 f-20 deleteMeeting"></i>
                                    </div>
                                    <input type="hidden" class="date" name="date" value="<?= date("Y-m-d", strtotime($meeting->date_meeting))?>">
                                    <input type="hidden" class="time" name="date" value="<?= $meeting->time_meeting?>">
                                    <p class="f-20 m-l-10"><?= date("l d F Y", strtotime($meeting->date_meeting))?> at <?= $meeting->time_meeting?></p>
                                    <hr>
                                    <p class="m-l-10 c-orange"><span class="f-16 c-gray objective"><?= $meeting->objective?></span></p>
                                    <p class="m-l-10 c-orange"><span class="f-15 c-gray m-r-5">Amount of attendees: </span> <?=count($meeting->getAttendees());?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse collapseExample collapseMeeting row" data-meeting-id="<?= $meeting->id?>">
                        <div class="col-md-7">
                            <div class="card card-block">
                               <p class="f-18 m-t-10 m-l-10 m-b-5">Attendees:</p>
                                <ul class="instructions-list">
                                    <? foreach($meeting->getAttendees() as $attendee) { ?>
                                        <input type="hidden" class="singleAttendee" data-user-id="<?= $attendee->user_id?>" value="<?= $attendee->user->getName()?>">
                                        <li class="instructions-list-item"><span class="c-gray"><?= $attendee->user->getName()?></span></li>
                                    <? } ?>
                                </ul>
                                <p class="f-18 m-t-10 m-l-10 m-b-5">Description:</p>
                                <p class="m-l-15 break-word description"><?= $meeting->description?></p>
                                <? if($meeting->max_duration_time != null) { ?>
                                    <?
                                        $maxDurations = new DateTime(date("g:i a", strtotime($meeting->max_duration_time)));
                                        $timeMeeting = new DateTime(date("g:i a",strtotime($meeting->time_meeting)));
                                        $interval = $timeMeeting->diff($maxDurations);
                                    ?>
                                    <p class="m-l-10">Max duration: <span class="c-orange"><?= $interval->format('%h hours, %i minutes');?></span></p>
                                    <p class="maxHours hidden"><?= $interval->format('%h');?></p>
                                    <p class="maxMinutes hidden"><?= $interval->format('%i');?></p>
                                    <p></p>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal teamLimitNotification fade" id="teamLimitNotification" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <p>We're sorry but this team has reached its max planned meetings. <br> To plan more meetings at the same time and make your innovative product even better you can take a look <a class="regular-link" href="/pricing">here</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade planNewMeeting fade-scale" id="planNewMeeting" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-border">
                        <div class="modal-header d-flex js-center modal-header-border">
                            <h4 class="modal-title text-center" id="modalLabel">Plan new meeting</h4>
                        </div>
                        <div class="modal-body modal-body-border">
                            <form action="/workspace/addNewMeeting" method="post" class="meetingForm">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="team_id" value="<?= $team->id?>">
                                <input type="hidden" id="meeting_id" name="meeting_id" value="">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="text" name="meetingObjective" class="input col-sm-5 meetingObjective" placeholder="Objective meeting:">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <textarea name="descriptionMeeting" class="input col-sm-10 m-t-20 descriptionMeeting" placeholder="Meeting description" cols="30" rows="4"></textarea>
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
                                                <input type="number" name="hours" max="24" min="0" class="input hours" value="1">
                                            </div>
                                        </div>
                                        <span class="m-l-10 m-r-10">Minutes:</span>
                                        <div class="row">
                                            <div class="col-sm-12 d-flex ">
                                                <input type="number" name="minutes" max="59" min="0" class="input minutes" value="1">
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
                                                            <option value="<?= $member->id?>"><?= $member->getName() . " - " . "Team leader"?></option>
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
                                        <button class="btn btn-inno pull-right submitMeetingModalBtn">Plan meeting</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceMeetings.js"></script>
@endsection