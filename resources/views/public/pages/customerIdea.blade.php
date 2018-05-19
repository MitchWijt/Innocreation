@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Your ideas for Innocreation</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form action="/page/submitCustomerIdea" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                                            <div class="row m-b-10">
                                                <div class="col-sm-12">
                                                    <p class="m-b-0 col-sm-12">title</p>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="idea_title" class="input" placeholder="Title">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="m-b-0 col-sm-12">Your idea!</p>
                                                    <div class="col-sm-12">
                                                        <textarea name="idea" class="col-sm-12 input" cols="30" rows="8" placeholder="Describe your idea!"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row m-t-10">
                                                <div class="col-sm-12 d-flex">
                                                    <div class="col-sm-10">
                                                        <ul class="instructions-list">
                                                            <li class="instructions-list-item"><span class="c-gray">Describe your idea as clear as possible </span></li>
                                                            <li class="instructions-list-item"><span class="c-gray">You will hear from us about your idea</span></li>
                                                            <li class="instructions-list-item"><span class="c-gray">We look at all of your ideas!</span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-inno">Submit</button>
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
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 m-l-20">
                                        <h3 class="f-20">Your submitted ideas</h3>
                                    </div>
                                    <div class="hr"></div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-4 text-center">
                                            <span class="f-13">Title</span>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <span class="f-13">Idea</span>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <span class="f-13">Status</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-card p-b-20"></div>
                                <? foreach($customerIdeas as $customerIdea) { ?>
                                    <div class="row customerIdea">
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-4 text-center">
                                                <p><?= $customerIdea->title?></p>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <p><?= $customerIdea->idea?></p>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <? if($customerIdea->customer_idea_status_id == 1) { ?>
                                                    <p class="c-orange"><?= $customerIdea->status->title?></p>
                                                <? } else if($customerIdea->customer_idea_status_id == 2) { ?>
                                                    <p class="c-green"><?= $customerIdea->status->title?></p>
                                                <? } else { ?>
                                                    <p class="c-red"><?= $customerIdea->status->title?></p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection