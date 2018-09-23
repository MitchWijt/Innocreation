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
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    <div class="card-lg col-sm-10 m-t-20 m-b-20 col-sm-pull-2">
                        <div class="card-block m-t-10">
                            <div class="col-sm-12 p-0">
                                <? if(isset($searchedExpertises)) { ?>
                                    <? foreach($searchedExpertises as $expertise) { ?>
                                        <div class="row">
                                            <div class="col-sm-6 @mobile text-center @endmobile">
                                                <a href="/<?= $expertise->slug?>/users" class="c-gray"><p class="m-b-0 m-t-20"><?= $expertise->title?></p></a>
                                            </div>
                                            <div class="col-sm-6 @mobile text-center p-b-20 @endmobile">
                                                <p class="m-b-0 m-t-20 @notmobile pull-right @endnotmobile">Active users: <?= count($expertise->getActiveUsers())?></p>
                                            </div>
                                        </div>
                                        <hr>
                                    <? } ?>
                                <? } else { ?>
                                    <? foreach($expertises as $expertise) { ?>
                                        <div class="row">
                                            <div class="col-sm-6 @mobile text-center @endmobile">
                                                <a href="/<?= $expertise->slug?>/users" class="c-gray"><p class="m-b-0 m-t-20"><?= $expertise->title?></p></a>
                                            </div>
                                            <div class="col-sm-6 @mobile text-center p-b-20 @endmobile">
                                                <p class="m-b-0 m-t-20 @notmobile pull-right @endnotmobile">Active users: <?= count($expertise->getActiveUsers())?></p>
                                            </div>
                                        </div>
                                        <hr>
                                    <? } ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
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