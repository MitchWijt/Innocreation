@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My needed expertises</h1>
            </div>
            <hr class="m-b-20">
            <form action="/my-team/addNeededExpertise" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<?=$team->id?>">
                <div class="row">
                    <div class="col-sm-12 d-flex js-center">
                        <div class="col-sm-7 p-l-0">
                        <p class="m-b-10">Add your needed expertise!</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 d-flex js-center">
                        <select name="expertises" class="input input-fat col-sm-7">
                            <? foreach($expertises as $expertise) { ?>
                                <option value="<?=$expertise->id?>"><?=$expertise->title?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 d-flex js-center m-t-20">
                        <button type="submit" class="btn btn-inno">Add expertise</button>
                    </div>
                </div>
                <hr class="m-t-25">
            </form>
            <? foreach($team->getNeededExpertises() as $neededExpertise) { ?>
                <?$requiredArray = []?>
                <? $counter = 0;?>
                <? $requirementExplode = explode(",",$neededExpertise->requirements)?>
                <?foreach($requirementExplode as $requirement) { ?>
                    <? $counter++;?>
                    <? array_push($requiredArray, $requirement)?>
                <? } ?>
                <div class="row d-flex js-center m-t-20">
                    <div class="card text-center">
                        <div class="card-block">
                            <p class="f-z-rem m-b-5 p-0"><?=$neededExpertise->expertises->First()->title?></p>
                        </div>
                    </div>
                </div>
                <form action="">
                    <div class="row">
                        <div class="col-sm-12 d-flex js-center m-t-10">
                            <textarea name="description_needed_expertise" class="input desc_needed_expertises" cols="65" rows="6"><?= $neededExpertise->description?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 d-flex js-center">
                            <h4 class="m-t-10">Requirements:</h4>
                        </div>
                    </div>
                    <? for($i = 0; $i < $counter; $i++) { ?>
                        <div class="row">
                            <div class="col-sm-9 d-flex js-center m-t-10">
                                <i class="zmdi zmdi-circle c-orange f-12 m-t-8 m-r-20"></i><input type="text" value="<?= $requiredArray[$i]?>" name="requirements[]" class="input">
                            </div>
                        </div>
                    <? } ?>
                </form>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/neededExpertisesTeam.js"></script>
@endsection