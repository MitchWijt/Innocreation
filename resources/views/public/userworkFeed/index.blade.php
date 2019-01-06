@extends("layouts.app")
@section("content")
    @mobile
    <? if(isset($user)) { ?>
        <div class="sliderUpDown close">
            <div class="sliderContent hidden">
                <div class="row p-l-10 p-r-10 m-t-10">
                    <div class="col-6">
                        <a class="regular-link closeSlider">Close</a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-inno btn-sm pull-right p-l-20 p-r-20 postInnocreativePost">Post</button>
                    </div>
                </div>
               <div class="hr-dark"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="/feed/postUserWork" method="post" class="userWorkForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <div class="m-b-5 d-flex js-center">
                                <div class="col-md-8 d-flex js-center m-t-5">
                                    <textarea placeholder="Share your idea, project or story" id="description_id" class="col-sm-12 input" rows="4" name="newUserWorkDescription"></textarea>
                                </div>
                            </div>
                            <div class="m-b-5 d-flex js-center">
                                <div class="col-md-8 m-t-5">
                                    <div class="row">
                                        <div class="@handheld col-6 @elsedesktop col-sm-4 @endhandheld">
                                            <select name="percentageProgress" class="input @handheld m-b-10 @endhandheld">
                                                <option value="" selected disabled>% @desktop Progress @enddesktop on project</option>
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
                                        <div class="@handheld col-6 m-b-10 @elsedesktop col-sm-4 @endhandheld">
                                            <div class="fileUpload p-relative">
                                                <input type="file" class="userwork_image hidden" name="image">
                                                <i class="zmdi zmdi-camera-add iconCTA addPicture c-pointer"></i>
                                                <span class="fileName pull-right m-r-10"></span>
                                                <i class="zmdi zmdi-link iconCTA c-pointer popoverAttachment " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverAttachment")?>'></i>
                                                <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                                            </div>
                                            <input type="hidden" placeholder="Your link" name="imageLink" class="input col-sm-12 attachmentLinkDB">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile p-relative previewBox hidden">
                                            <i class="zmdi zmdi-close c-orange f-25 p-absolute c-pointer" id="removePreview" style="top: 2%; right: -63%;"></i>
                                            <img style="width: 200px; height: 200px;" id="previewUpload" src="#" alt="PreviewUpload"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
    @endmobile
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
            <div class="sub-title-container p-t-20 m-b-20">
                <h1 class="sub-title-black m-b-0">Innocreatives</h1>
            </div>
            <hr class="m-b-20">
            <? if(isset($user)) { ?>
                <input type="hidden" class="userJS" value="1">
                <div class="userworkPostForm">
                    @notmobile
                        <form action="/feed/postUserWork" method="post" class="userWorkForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <div class="m-b-5 d-flex js-center">
                                <div class="col-md-8 d-flex js-center m-t-5">
                                    <textarea placeholder="Share your idea, project or story" id="description_id" class="col-sm-12 input @notmobile contentActive @endnotmobile descDesktop c-pointer" rows="2" name="newUserWorkDescription"></textarea>
                                </div>
                            </div>
                            <div class="m-b-5 d-flex js-center extraOptions hidden">
                                <div class="col-md-8 m-t-5 @notmobile contentActive @endnotmobile">
                                    <div class="row contentClick">
                                        <div class="@handheld col-6 @elsedesktop col-sm-4 @endhandheld">
                                            <select name="percentageProgress" class="input @handheld m-b-10 @endhandheld">
                                                <option value="" selected disabled>% @desktop Progress @enddesktop on project</option>
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
                                        <div class="@handheld col-6 m-b-10 @elsedesktop col-sm-4 @endhandheld contentActive">
                                            <div class="fileUpload p-relative contentActiveIcons">
                                                <input type="file" class="userwork_image hidden" name="image">
                                                <i class="zmdi zmdi-camera-add iconCTA addPicture c-pointer"></i>
                                                <i class="zmdi zmdi-link iconCTA c-pointer popoverAttachment " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverAttachment")?>'></i>
                                                <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                                            </div>
                                            <input type="hidden" placeholder="Your link" name="imageLink" class="input col-sm-12 attachmentLinkDB">
                                        </div>
                                        <div class="@handheld col-12 m-b-10 @elsedesktop col-sm-4 @endhandheld">
                                           <button type="button" class="btn btn-inno btn-sm pull-right submitPost">Post!</button>
                                        </div>
                                    </div>
                                    @tablet
                                        <div class="row">
                                            <div class="col-sm-4 p-relative previewBox hidden">
                                                <i class="zmdi zmdi-close c-orange f-20 p-absolute c-pointer hidden" id="removePreview" style="top: 3%; right: 28% !important;"></i>
                                                <img style="width: 100px; height: 100px;" id="previewUpload" src="#" alt="PreviewUpload"/>
                                            </div>
                                        </div>
                                    @elsedesktop
                                        <div class="row">
                                            <div class="col-sm-4 p-relative previewBox hidden">
                                                <i class="zmdi zmdi-close c-orange f-25 p-absolute c-pointer hidden" id="removePreview" style="top: 3%; right: 15% !important;"></i>
                                                <img style="width: 200px; height: 200px;" id="previewUpload" src="#" alt="PreviewUpload"/>
                                            </div>
                                        </div>
                                    @endtablet
                                </div>
                            </div>
                        </form>
                    @elsemobile
                        <div class="d-flex js-center m-b-5">
                            <div class="col-md-8 m-t-5">
                                <p class="c-dark-grey iconCTA col-sm-12 p-b-40 triggerSlider">Share your ideas, project or story</p>
                            </div>
                        </div>
                    @endnotmobile
                </div>
            <? } else { ?>
                <input type="hidden" class="userJS" value="0">
                <div class="text-center m-b-20">
                    <p class="@mobile f-14 @elsedesktop f-20 @endmobile text-center"><a class="regular-link" href="/create-my-account">Create an account</a> or <a class="regular-link" href="/login">login</a> to post your work!</p>
                </div>
            <? } ?>
            <div class="row d-flex js-center userworkData m-t-20">

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