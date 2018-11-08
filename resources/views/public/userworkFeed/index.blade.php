@extends("layouts.app")
@section("content")
    <input type="hidden" class="totalAmount" value="<?= $totalAmount?>">
    <? if(isset($user) && $user->hasContent()) { ?>
        <input type="hidden" class="userId" value="<?= $user->id?>">
    <? } else { ?>
        <input type="hidden" class="userId" value="0">
    <? } ?>
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black m-b-0">Innocreatives</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i class="f-12 c-dark-grey">Share your best project/story!</i>
                </div>
            </div>
            <hr class="m-b-20">
            <? if(isset($user)) { ?>
            <input type="hidden" class="userJS" value="1">
                <div class="row">
                    <div class="col-sm-12 d-flex js-center c-dark-grey">
                        <i class="zmdi zmdi-plus-circle openForm f-40 m-b-20 c-pointer"></i>
                    </div>
                </div>
                <div class="userworkPostForm hidden">
                    <form action="/feed/postUserWork" method="post" class="userWorkForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                        <div class="row m-b-5 p-relative">
                            <i class="zmdi zmdi-close c-orange f-19 p-absolute closeForm" @handheld @mobile style="top: -15px; right: 30px;" @elsetablet style="top: -15px; right: 140px;" @endmobile @elsedesktop style="top: -15px; right: 205px;" @endhandheld></i>
                            <div class="col-md-12 d-flex js-center m-t-5">
                                <textarea placeholder="Post your best work!" id="description_id" class="col-sm-8 input" rows="2" name="newUserWorkDescription"> </textarea>
                            </div>
                        </div>
                        <div class="row m-b-5 d-flex js-center">
                            <div class="col-md-8 m-t-5">
                                <div class="row m-b-20">
                                    <div class="@handheld col-12 @elsedesktop col-sm-4 @endhandheld">
                                        <select name="percentageProgress" class="input @handheld pull-right m-b-10 @endhandheld">
                                            <option value="" selected disabled>% Progress on project</option>
                                            <option value="10%">10% finished</option>
                                            <option value="20%">20% finished</option>
                                            <option value="30%">30% finished</option>
                                            <option value="40%">40% finished</option>
                                            <option value="50%">50% finished</option>
                                            <option value="60%">60% finished</option>
                                            <option value="70%">70% finished</option>
                                            <option value="80%">80% finished</option>
                                            <option value="90%">90% finished</option>
                                            <option value="100%">100% finished</option>
                                        </select>
                                    </div>
                                    <div class="@handheld col-12 m-b-10 @elsedesktop col-sm-4 @endhandheld">
                                        <div class="fileUpload">
                                            <input type="file" class="userwork_image hidden" name="image">
                                            <i class="zmdi zmdi-camera-add iconCTA addPicture c-pointer"></i>
                                            <span class="fileName pull-right m-r-10"></span>
                                            <i class="zmdi zmdi-link iconCTA c-pointer popoverAttachment" data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverAttachment")?>'></i>
                                            <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis" data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                                        </div>
                                        <input type="hidden" placeholder="Your link" name="imageLink" class="input col-sm-12 attachmentLinkDB">
                                    </div>
                                    <div class="@handheld col-12 m-b-10 @elsedesktop col-sm-4 @endhandheld">
                                       <button type="submit" class="btn btn-inno btn-sm pull-right">Post!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <? } else { ?>
                <input type="hidden" class="userJS" value="0">
                <div class="text-center m-b-20">
                    <p class="f-20 text-center"><a class="regular-link" href="/create-my-account">Create an account</a> or <a class="regular-link" href="/login">login</a> to post your work!</p>
                </div>
            <? } ?>
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
    <script>
        $('body').on('click', function (e) {
            $('[data-toggle=popover]').each(function () {
                // hide any open popovers when the anywhere else in the body is clicked
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
        $('.popoverAttachment').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});
        $('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});

    </script>
@endsection
@section('pagescript')
    <script src="/js/userworkFeed/index.js"></script>
@endsection