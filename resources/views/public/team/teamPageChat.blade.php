@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team chat</h1>
            </div>
            <hr class="col-ms-12">
            <div class="row d-flex js-center">
                <div class="card col-sm-11 member m-t-20 m-b-20">
                    <div class="card-block">
                        <div class="row text-center">
                            <div class="col-sm-12 m-t-20 m-b-20 d-flex">
                                <div class="col-sm-4">
                                    <img class="circleImage" src="<?= $team->getProfilePicture()?>" alt="<?= $team->team_name?>">
                                </div>
                                <div class="col-sm-4">
                                    <h3><?= $team->team_name?></h3>
                                    <p class="c-orange"><?= count($team->getMembers())?> members</p>
                                </div>
                                <div class="col-sm-4 m-t-10">
                                    <a href="/team/<?=$team->team_name?>" class="btn btn-inno">Go to live page</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex js-center">
                            <hr class="col-sm-12 m-b-20">
                        </div>
                        <div class="o-scroll" style="height: 400px;">
                        <? foreach($messages as $message) { ?>
                            <? if($message->sender_user_id == $user->id) { ?>
                                   <div class="row">
                                       <div class="col-sm-12">
                                           <div class="col-sm-5 messageSent pull-right m-b-10">
                                                <p><?= $message->message?></p>
                                               <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                           </div>
                                       </div>
                                   </div>
                            <? } else { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-5 pull-left m-b-10 messageReceived">
                                            <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                                                <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - CEO:</p>
                                            <? } else { ?>
                                                <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - <?= $message->sender->First()->getJoinedExpertise()->expertises->First()->title?>:</p>
                                            <? } ?>
                                            <p><?= $message->message?></p>
                                            <span class="f-12 pull-right"><?=$message->time_sent?></span>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        <? } ?>
                        </div>
                        <div class="d-flex js-center">
                            <hr class="col-sm-12 m-b-20">
                        </div>
                        <? if($user->muted <= date("Y-m-d H:i:s")) { ?>
                        <form action="/my-team/sendTeamMessage" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="team_id" value="<?=$team->id?>">
                            <input type="hidden" name="sender_user_id" value="<?=$user->id?>">

                            <div class="row m-t-20">
                                <div class="col-sm-12 text-center">
                                    <textarea name="teamMessage" placeholder="Send your message..." class="input col-sm-10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-11 m-b-20 m-t-20">
                                    <button class="btn btn-inno pull-right">Send message</button>
                                </div>
                            </div>
                        </form>
                        <? } else { ?>
                        <?
                            $today = new DateTime(date("Y-m-d H:i:s"));
                            $date = new DateTime(date("Y-m-d H:i:s",strtotime($user->muted)));
                            $interval = $date->diff($today);
                        ?>
                        <div class="row m-t-20 m-b-10">
                            <div class="col-sm-12 text-center">
                                <p>You have been muted for <?= $interval->format('%h hours, %i minutes, %s seconds');?></p>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection