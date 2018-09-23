<?
     $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div class="col-sm-12 d-flex js-center m-b-20 p-l-0">
    <div class="supportTicket">
        <?if(strpos($url, "/my-team/members")){ ?>
            @handheld
                <div class="card" style="max-width: 300px;">
            @elsedesktop
                <div class="card" style="max-width: 600px;">
            @endhandheld
            {{--<div class="card" style="max-width: 450px;">--}}
        <? } else { ?>
            @handheld
                @tablet
                    <input type="hidden" name="mobile" class="mobile" value="0">
                    <div class="card" style="max-width: 325px;">
                @elsemobile
                    <input type="hidden" name="mobile" class="mobile"  value="1">
                    <div class="card">
                @endtablet
            @elsedesktop
                <input type="hidden" name="mobile" class="mobile"  value="0">
                <div class="card" style="max-width: 600px;">
            @endhandheld
        <? } ?>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-9">
                        <p class="m-l-5">Innocreation helper</p>
                    </div>
                    <div class="col-sm-3">
                        <form action="/user/finishHelper" method="post">
                            <? if(isset($user)) { ?>
                                <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <? } ?>
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <button class="btn btn-sm btn-inno m-t-5">Close helper</button>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row m-l-5 m-b-20">
                    @notmobile
                    <div class="col-sm-4">
                        <img width="100%" src="/images/Mascot.png" alt="Inno_mascot">
                    </div>
                    @endnotmobile
                    <div class="@mobile col-sm-12 @elsedesktop col-sm-8 @endnotmobile">
                        <div class="m-r-5">
                            <? if(strpos($url, "/account") != false) { ?>
                                <p>Hey! welcome to Innocreation. Let me introduce myself. I am Inno and my motivation is to help you understand Innocreation at its best!  I am curious about you. who are you and what is your motivation?</p>
                                <button class="btn btn-inno toMotivation m-b-10">Introduce myself!</button>
                                <p class="helperTextCredentials"></p>
                                <a href="/my-account/expertises" class="btn btn-inno continueStep1 hidden">Let's continue <i class="zmdi zmdi-long-arrow-right"></i> </a>
                            <? } else if(strpos($url, "/expertises")){ ?>
                                <p>Here we have your expertises. I'm specialized in Helping you as much as i can. What makes you the best in your expertise(s)?</p>
                                <p>Click on "edit experience" to edit your experience!</p>
                                <p class="helperTextExpertises"></p>
                                <a href="/my-account/portfolio" class="btn btn-inno continueStep2 hidden">To portfolio </a>
                            <? } else if(strpos($url, "/portfolio")){ ?>
                                <p>Here at your portfolio you can add your recent work associated with your expertises:</p>
                                <? if(isset($user)) { ?>
                                    <? foreach($user->getExpertises() as $expertise) { ?>
                                        <p class="m-0"><?= $expertise->title?></p>
                                    <? } ?>
                                <? } ?>
                                <a href="/my-account/teamInfo" class="f-12 c-dark-grey pull-right">I'll do this later</a>
                            <? } else if(strpos($url, "/teamInfo")){ ?>
                                <p>So you want to bring your idea to life? Lets start by <button class="btn btn-inno btn-sm" data-toggle="modal" data-target="#myModal">Creating a team</button> You only have to fill in the team name. The rest comes later!</p>
                                <p>Or if you prefer joining a team you can <button class="btn btn-inno btn-sm joinTeamBtn">Join a team</button> If thats the case. I will wish you good luck on your creative and innovative journey! Your team will help you out with the rest ;) See ya!</p>
                                <form action="/user/joinTeamFromHelper" method="post" class="hidden joinTeamForm">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                                </form>
                            <? } else if(!strpos($url, "/my-team/members") && !strpos($url, "/forum") && !strpos($url, "/my-team/team-chat") && !strpos($url, "/my-team/workspace")){ ?>
                                <p>Just like i was exited to know you and your motivation. Here you can fill those in aswell but for your team!</p>
                                <p>I understand you might need some time to think about this :)</p>
                                <p>But anyways. Amazing team! you're doing great! I am guessing you won't create the idea on your own. So lets:</p>
                                <a href="/my-team/members" class="btn btn-inno">Continue to members</a>
                            <? } else if(strpos($url, "/my-team/members")){ ?>
                                <div class="helperTextTeamMembersFirst">
                                    <p>As you can see. Only you are a member. But... Lets change that! You can either start <a class="generateInviteLink regular-link" data-team-id="<? if(isset($user) && $user->team_id != null) echo $user->team_id?>">inviting friends</a> directly with a link, or look at the forum for members!</p>
                                    <button class="btn btn-inno continueStep3">Continue</button>
                                </div>
                                <p class="helperTextTeamMembers hidden"> To chat with all the members. The team has a group chat. But we understand that sometimes you'll need private conversations with certain people so you can create custom group chats with members!</p>
                                <a href="/my-team/team-chat" class="btn btn-inno toChatBtn hidden">To chat</a>
                            <? } else if(strpos($url, "/my-team/team-chat")){ ?>
                                <p>Here you can chat and create group chats! ofcourse for your team we also have a special workspace!</p>
                                <a href="/my-team/workspace" class="btn btn-inno">To the workspace</a>
                            <? } else if(strpos($url, "/my-team/workspace") && !strpos($url, "/my-team/workspace/short-term-planner-options")){ ?>
                                <p>Welcome to your team's workspace! Lets read the benefits and <a href="/my-team/workspace/short-term-planner-options" class="btn btn-inno">go to work!</a></p>
                            <? } else if(strpos($url, "/my-team/workspace/short-term-planner-options")){ ?>
                                <p>So you want to plan tasks! choose a planner that fits your needs and go to work on your idea!</p>
                                <p>Now you know some of the key features in Innocreation. It was a pleasure helping you and I wish you goodluck on your journey! See ya!</p>
                                <form action="/user/finishHelper" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <? if(isset($user)) { ?>
                                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                                    <? } ?>
                                    <button class="btn btn-inno">Close</button>
                                </form>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>