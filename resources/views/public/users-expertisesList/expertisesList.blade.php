@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">All expertises</h1>
            </div>
            <hr class="m-b-0">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    <div class="card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="col-sm-12">
                                <? foreach($expertises as $expertise) { ?>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-6">
                                                <a href="/<?= $expertise->title?>/users" class="c-gray"><p class="m-b-0 m-t-20"><?= $expertise->title?></p></a>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-0 m-t-20 pull-right">Active users: <?= count($expertise->getActiveUsers())?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection