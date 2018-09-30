@extends("layouts.app")
@section("content")
    <input type="hidden" class="totalAmount" value="<?= $totalAmount?>">
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black m-b-0">Innocreatives</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i class="f-12 c-dark-grey">Post your best work/project for everyone to see!</i>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">

            <div class="row d-flex js-center userworkData">

            </div>
        </div>
        <? if(isset($sharedUserWorkId)) { ?>
            <input type="hidden" class="sharedUserWorkId" value="<?= $sharedUserWorkId?>">
        <? } else { ?>
            <input type="hidden" class="sharedUserWorkId" value="0">
        <? } ?>
        <? if(isset($user)) { ?>
            <div class="modal fade shareUserWork" id="shareUserWork" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <? if($user->team_id != null) { ?>
                            @desktop
                            <div class="row d-flex js-center">
                                <div class="col-md-12 text-center">
                                    <input type="radio" name="radio" id="user" class="shareWithUsersRadio input"><label for="user" class="m-r-30">Share with users</label>
                                    <input type="radio" name="radio" id="team" class="input shareWithTeam "><label for="team">Share with my team</label>
                                </div>
                            </div>
                            @elsemobile
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="radio" name="radio" id="user" class="shareWithUsersRadio input m-r-5"><label for="user" class="m-r-30">Share with users</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="radio" name="radio" id="team" class="input shareWithTeam m-r-5"><label for="team">Share with my team</label>
                                </div>
                            </div>
                            @endmobile
                            <? } ?>
                            <? if($user->team_id != null) { ?>
                                <hr class="m-b-20 col-md-10">
                            <? } ?>
                            <form action="/feed/shareFeedPost" class="shareTeamProductUsersForm" method="post">
                                <input type="hidden" class="sharedLink" value="">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <div class="shareWithUsers <? if($user->team_id != null) echo "hidden" ?>">
                                    <div class="row m-t-20">
                                        <div class="col-sm-6">
                                            <input type="text" name="searchUsers" placeholder="search users..." class="input m-r-5 searchUsersInput"><button type="button" class="btn btn-inno btn-sm searchUsers">Search</button>
                                            <div class="resultList m-b-20">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-0">Selected users:</p>
                                            <ul class="selectedUsers">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="shareProductMessage <? if($user->team_id != null) echo "hidden" ?>">
                                    <textarea name="shareProductMessage" class="col-sm-12 input message" rows="10"></textarea>
                                    <button class="btn btn-inno pull-right">Share product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
@endsection
@section('pagescript')
    <script src="/js/userworkFeed/index.js"></script>
@endsection