@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Teams</h1>
            </div>
            <div class="hr p-b-20"></div>
            <div class="d-flex js-around p-b-20">
                <a href="/teams" class="btn btn-inno c-gray joinTeamBtn">Join a team</a>
                <a class="btn btn-inno c-gray" data-toggle="modal" data-target="#myModal">Create a team</a>
            </div>
            <div class="row d-flex js-center p-b-20">
                <div class="card card-lg text-center">
                    <div class="card-block">
                        <div class="sub-title-container p-t-20">
                            <h1 class="sub-title-black c-gray">Benefits</h1>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <ul class="instructions-list">
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Develop your ideas with your own team</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Build your own team with creative and smart people</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Getting your ideas or products out there</p>
                           </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Share your team products on the feed</p>
                            </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Be a team leader of your own team</p>
                           </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- MODAL CREATE A TEAM -->
            <div class="modal fade fade-scale" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-border">
                        <div class="modal-header modal-header-border d-flex js-center">
                            <h4 class="modal-title text-center" id="modalLabel">Create your team!</h4>
                        </div>
                        <div class="modal-body modal-body-border">
                            <form action="/createTeam" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<?= $user->id?>">
                                <div class="form-group">
                                    <? if(isset($error)) { ?>
                                        <div class="d-flex js-center">
                                            <span class="c-orange"><?= $error ?></span>
                                        </div>
                                    <? } ?>
                                    <div class="d-flex js-around text-center">
                                        <p class="m-t-10">Team name:</p>
                                        <input class="input m-t-10" type="text" name="team_name" id="" style="height: 30px;">
                                    </div>
                                    <div class="row m-t-20 ">
                                        <div class="col-sm-11">
                                            <button class="btn btn-inno pull-right">Create my team</button>
                                        </div>
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