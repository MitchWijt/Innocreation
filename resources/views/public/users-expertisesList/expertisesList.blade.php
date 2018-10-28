@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">All expertises</h1>
            </div>
            <hr class="m-b-0">
            <form action="/userExpertiseList/searchExpertise" class="searchExpertiseForm" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <div class="form-group m-b-0 d-flex js-center p-relative expertises">
                    <div class="row d-flex js-center col-sm-12 m-t-20">
                        <div class="@mobile col-9 @elsedesktop col-sm-9 @endmobile p-r-0 searchBar">
                            <input type="text" id="tags" placeholder="Search for the expertise you need..." class="input p-b-10 col-sm-12 b-t-r-0 b-b-r-0 searchInput" name="searchedExpertise" value=""/>
                        </div>
                        <div class="@mobile col-2 @elsedesktop col-sm-2 @endmobile m-0 p-0">
                            <button class="btn btn-inno btn-block b-t-l-0 b-b-l-0 searchButton"><i class="zmdi zmdi-search f-21"></i></button>
                        </div>
                    </div>
                </div>
            </form>
            <? $counter = 0;?>
            @handheld
            <? $modulo = 1?>
            <? $result1 = 0 ?>
            <? $result2 = 0?>
            @elsedesktop
            <? $modulo = 2?>
            <? $result1 = 0?>
            <? $result2 = 1?>
            @endhandheld
            <div class="row">
            <? foreach($expertises as $expertise) { ?>
                <div class="col-sm-4">
                    <div class="card m-t-20 m-b-20 @tablet p-10 @endtablet" >
                        <div class="card-block expertiseCard p-relative c-pointer" data-url="<?= $expertise->slug?>/users" style="max-height: 210px !important">
                            <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                <a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                            </div>
                            <div class="p-t-40 p-absolute" style="z-index: 102; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <p class="c-white f-20">Active users: <?= count($expertise->getActiveUsers())?></p>
                            </div>
                            <div class="p-t-40 p-absolute" style="z-index: 100; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                <div class="hr-sm"></div>
                            </div>
                            <div class="p-t-40 p-absolute" style="z-index: 99; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                <p class="c-white f-20"><?= $expertise->title?></p>
                            </div>
                            <div class="overlay">
                                <div class="contentExpertise" style="background: url('<?= $expertise->image?>');"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            </div>
        </div>
    </div>
    <script>
        $( function() {
            var availableTags = [
                <? foreach($allTags as $tag) { ?>
                    "<?=$tag?>",
                <? } ?>
            ];
            $( "#tags" ).autocomplete({
                source: availableTags
            });
        } );
        $(document).ready(function () {
            $(".ui-menu").appendTo(".expertises");
        });
    </script>
    <style>

    </style>
@endsection
@section('pagescript')
    <script src="/js/expertisesList/expertisesList.js"></script>
@endsection