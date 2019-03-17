@extends("layouts.app")
<link rel="stylesheet" href="/css/responsiveness/innocreativeFeed/index.css">
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme();?>">
        @mobile
        <? if(isset($user)) { ?>
            <div class="sliderUpDown close p-relative">
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
                                            <div class="@handheld col-6 m-b-10 @elsedesktop col-sm-4 @endhandheld">
                                                <div class="fileUpload p-relative">
                                                    <input type="file" class="userwork_image hidden" name="image">
                                                    <i class="zmdi zmdi-camera-add iconCTA addPicture c-pointer"></i>
                                                    <span class="fileName pull-right m-r-10"></span>
                                                    <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                                                </div>
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
        <? if(isset($sharedUserWorkId)) { ?>
            <input type="hidden" class="sharedLinkId" value="<?= $sharedUserWorkId?>">
        <? } ?>
        <div class="d-flex grey-background <?= \App\Services\UserAccount\UserAccount::getTheme();?>">
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
                    <div class="userworkPostForm text-center">
                        @notmobile
                            <button class="btn btn-inno-cta m-t-25" data-toggle="modal" data-target="#postUserWorkModal">I want to post my passion</button>
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
                <div class="userworkData m-t-40 grid-container" data-page="feedPage">

                </div>
            </div>
        </div>
    </div>
    <? if(isset($user)) { ?>
        <div class="modal postUserWorkModal  fade fade-scale o-scroll <?= \App\Services\UserAccount\UserAccount::getTheme();?>" id="postUserWorkModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <i class="zmdi zmdi-close c-pointer c-orange f-30" data-dismiss="modal" @desktop style="top: 1%; right: 1%; z-index: 1; position: fixed !important" @elsemobile style="top: 5%; right: 5%; z-index: 1; position: fixed !important" @enddesktop></i>
            <div class="modal-dialog modal-lg fixed-modal modal-dialog-centered custom-dialog-margin" role="document">
                <div class="modal-content modal-content-border">
                    <div class="submittingForm">
                        <p class="f-30 bold p-l-20 m-b-10 m-t-30">Choose your passion image.</p>
                        <div class="p-l-20 p-r-20 text-center">
                            <p class="f-20 p-b-40 p-r-40 p-l-40 p-t-40" id="dropContainer" style="border: 1px dashed #000">Drop your image or <button class="btn btn-inno-cta browseImage">Browse</button></p>
                        </div>
                        <input type="file" name="image" class="hidden input_image" id="image">
                        <div class="row p-l-30">
                            <div class="previewBox hidden p-relative">
                                <img style="width: 200px; height: 200px;" id="previewUpload" class="p-relative p-l-5" src="#" alt="PreviewUpload"/>
                                <i class="zmdi zmdi-close c-orange f-30 p-absolute c-pointer hidden" id="removePreview" style="top: 3%; right: 3% !important;"></i>
                            </div>
                            <span class="errorMimetype c-red f-12 hidden p-l-5">It seems you are trying to upload a file with the wrong extension. Only .jpg and .jpeg images are allowed.</span>
                        </div>
                        <p class="f-30 bold p-l-20 m-b-0 m-t-40">Write your caption</p>
                        <div class="m-t-10 p-l-15">
                            <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                            <textarea name="comment" id="description_id" placeholder="Write your comment..." class="comment input col-sm-11 messageInputDynamic no-focus" rows="1"></textarea>
                        </div>
                        <div class="m-t-15 d-flex js-center @mobile m-r-20 @endmobile">
                            <div class="col-sm-11 p-r-0 m-b-10">
                                <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis pull-right c-black" data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                            </div>
                        </div>
                        <p class="f-30 bold p-l-20 m-b-0 m-t-40">What are your related expertises to this post?</p>
                        <div class="m-t-10 p-l-20 p-r-20" style="margin-bottom: 50px;">
                            <input type="text" class="input p-b-5 tokenfieldPost" name="expertises" id="tokenfieldPost" value=""/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-r-35 m-b-30">
                                <img class="loadingGear hidden pull-right" id="loadingPostRequest" src="/images/icons/loadingGear.gif" style="width: 30px !important; height: 30px !important" alt="">
                                <button class="btn btn-inno-cta pull-right submitPost">Submit post</button>
                            </div>
                        </div>
                    </div>
                    <div class="completedPostRequest text-center hidden">
                        <i class="zmdi zmdi-check c-black p-l-30 p-r-30 p-t-20 p-b-20 m-t-30" style="border: 1px solid limegreen; border-radius: 100%; font-size: 80px;"></i>
                        <p class="f-30 bold p-l-20 m-t-30" style="margin-bottom: 50px;">Thank you for sharing your passion!</p>
                        <p class="m-b-5">Your post is being reviewed by our team at the moment</p>
                        <p class="m-b-30">This will take approximately 2 hours. You will be notified of any updates!</p>
                        <p class="m-b-5">Your post will not be visible for others in the feed before the validation. </p>
                        <p style="margin-bottom: 50px;">However it will be visible for yourself in your account!</p>
                        <a style="margin-bottom: 50px;" href="<?= $user->getUrl()?>" class="btn btn-inno-cta">To my account</a>
                        <p style="margin-bottom: 50px;">It’s people like you that build the foundation of collaboration and creation!</p>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>

    <? if(isset($user)) { ?>
        <script>
                var expertisesArray = [];

                $('#tokenfieldPost').tokenfield({
                    autocomplete: {
                        source: [
                            <? foreach($expertises as $expertise) { ?>
                                <? $title = $expertise->title ?>
                                expertisesArray.push("<?= $title?>"),
                            <? if(strpos($expertise->title,"-") !== false) { ?>
                               <? $title = str_replace("-"," ",$title); ?>
                                expertisesArray.push("<?= $title?>")
                            <? } ?>
                            <?= "'$title'"?>,
                            <? } ?>
                        ],
                        delay: 100
                    },
                    showAutocompleteOnFocus: true,
                    createTokensOnBlur: true
                });

                $('#tokenfieldPost').on('tokenfield:createtoken', function (event) {
                    var exists = false;
                    $.each(expertisesArray, function(index, value) {
                        if (event.attrs.value === value) {
                            exists = true;
                        }
                    });
                    if(!exists) {
                        event.preventDefault(); //prevents creation of token
                    }
                });
        </script>
    <? } ?>
@endsection
@section('pagescript')
    <script src="/js/userworkFeed/index.js"></script>
    <script src="/js/userworkFeed/feed.js"></script>
@endsection