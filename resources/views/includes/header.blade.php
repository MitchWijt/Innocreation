<header class="headerShow no-select">
        @handheld
            <div class="p-t-10 container">
        @elsedesktop
            <div class="p-t-5 container-fluid">
        @endhandheld
        <div class="row desktopNav">
            <div class="col-sm-12">
                <div class="pull-left d-flex m-t-20 m-l-35">
                    <div class="logoDiv">
                        <a class="td-none" href="/">
                            <img class="cartwheelLogo m-r-10" src="/images/cartwheel.png" alt="" style="width: 50px !important; height: 50px !important;">
                        </a>
                    </div>
                    <div class="m-b-20 m-t-5 searchBarBox" style="min-width: 100px !important">
                        <div class="input-group mb-3 no-focus expertisesHeader">
                            <div class="input-group-prepend no-focus">
                                <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                            </div>
                            <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeader" class="form-control no-focus form-control-inno" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="pull-right navBtns">
                    <div class="pull-right">
                        <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                <div class="m-t-20 pull-right m-r-30 c-gray p-relative">
                                    <i class="popoverNotifications zmdi zmdi-notifications c-gray f-25 m-r-10 m-t-5 c-pointer moreChev" data-toggle="popover" data-content='<?= view("/public/shared/_popoverNotificationBox")?>'></i>
                                    <i class="zmdi zmdi-circle c-orange f-13 p-absolute <? if($counterMessages < 1) echo "hidden";?> notificationIdicator" style="top: 10%; left: 3%;"></i>
                                    <a class="btn btn-inno btn-sm" href="/expertises">Collaborate</a>
                                    <? if($user->team_id != null) { ?>
                                        <a class="btn btn-inno btn-sm" href="/my-team">Team</a>
                                    <? } else { ?>
                                        <a class="btn btn-inno btn-sm" href="/my-account/teamInfo">Create team</a>
                                    <? } ?>
                                    <a class="btn btn-inno btn-sm" href="/innocreatives">Share</a>
                                    <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-25 m-l-15 m-t-5 c-pointer moreChev" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                                    <div class="pull-right">
                                        <a href="/my-account">
                                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                                        </a>
                                    </div>
                                </div>
                            <? } else { ?>
                            <div class="m-t-20 pull-right m-r-30 c-gray" style="width: 100%">
                                <a class="btn btn-inno btn-sm m-r-5 usersHeader" href="/expertises">Users</a>
                                <a class="btn btn-inno btn-sm feedHeader" href="/innocreatives">Feed</a>
                                <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-20 m-l-15 m-t-5 c-pointer moreChev" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                                <span class="btn-seperator m-l-15 m-r-10"></span>
                                <a class="td-none m-l-10 m-r-10 loginBtn" href="/login"><span class="c-gray">Login</span></a>
                                <a class="btn btn-inno btn-success joinBtn" href="/create-my-account">Join for free</a>
                            </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <? if(!\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                <div class="row m-t-20 navMobile m-r-0 m-l-0">
                    <div class="col-3 text-center">
                        <a href="/">
                            <img class="cartwheelLogo" src="/images/cartwheel.png" alt="" style="width: 30px !important; height: 30px !important;">
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <i class="zmdi zmdi-search searchBtnHomeMobile c-gray f-30"></i>
                    </div>
                    <div class="col-3 text-center">
                        <a href="/innocreatives">
                            <i class="zmdi zmdi-share c-gray f-30"></i>
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <a href="/expertises">
                            <i class="zmdi zmdi-accounts-alt c-gray f-30"></i>
                        </a>
                    </div>
                </div>
                <div class="m-b-20 m-t-5 searchBarBox hidden p-15" id="expertisesHeaderMob" style="min-width: 100px !important;">
                    <i class="zmdi zmdi-long-arrow-left c-orange f-22 pull-right m-r-5 closeSearchBar"></i>
                    <div class="input-group mb-3 no-focus">
                        <div class="input-group-prepend no-focus">
                            <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                        </div>
                        <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeaderMobile" class="form-control no-focus form-control-inno" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="m-t-20 p-r-10 p-b-15 registerBtnsMobile" style="display: none;">
                    <div class="col-6">
                        <a class="btn btn-normal td-none m-l-10 m-r-10 loginBtn btn-block" href="/login"><span class="c-gray">Login</span></a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-inno btn-success joinBtn btn-block" href="/create-my-account">Join for free</a>
                    </div>
                </div>
            <? } else { ?>
                <div class="row m-t-30 navMobile m-r-0 m-l-0">
                    <div class="col-3 text-center">
                        <a href="/">
                            <img class="cartwheelLogo" src="/images/cartwheel.png" alt="" style="width: 30px !important; height: 30px !important;">
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <i class="zmdi zmdi-search searchBtnHomeMobile c-gray f-30"></i>
                    </div>
                    <div class="col-3 text-center">
                        <a href="/innocreatives">
                            <i class="zmdi zmdi-share c-gray f-30"></i>
                        </a>
                    </div>
                    <div class="col-3 text-center d-flex">
                        <a href="/my-account" class="m-r-10">
                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                        </a>
                        <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-20 c-pointer m-t-10" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>

                    </div>
                </div>
                <div class="m-t-5 searchBarBox hidden p-15" id="expertisesHeaderMob" style="min-width: 100px !important;">
                    <i class="zmdi zmdi-long-arrow-left c-orange f-22 pull-right m-r-5 closeSearchBar"></i>
                    <div class="input-group mb-3 no-focus">
                        <div class="input-group-prepend no-focus">
                            <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                        </div>
                        <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeaderMobile" class="form-control no-focus form-control-inno" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</header>
<? $expertises = \App\Expertises::select("*")->get();?>
<script>
    $( function() {
        var availableTags = [
            <? foreach($expertises as $tag) { ?>
                "<?=$tag->title?>",
            <? } ?>
        ];
        $( "#tagsHeader" ).autocomplete({
            source: availableTags
        });
        $( "#tagsHeaderMobile" ).autocomplete({
            source: availableTags
        });
    } );

    window.mobilecheck = function() {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };
    if(window.mobilecheck())
    {
        $("#tagsHeaderMobile").on("keyup", function () {
            $(".ui-menu").appendTo("#expertisesHeaderMob");
        });
    } else {
        $("#tagsHeader").on("keyup", function () {
            $(".ui-menu").appendTo(".expertisesHeader");
        });
    }
    $(document).ready(function () {
        $(".ui-menu").addClass("ui-menu-home");
    });
</script>