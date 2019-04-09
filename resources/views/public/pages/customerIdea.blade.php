@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black bold">Your ideas for Innocreation</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center">
                <div class="col-md-9 m-t-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="/page/submitCustomerIdea" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<?= $user->id?>">
                                <div class="row m-b-30">
                                    <div class="col-sm-12">
                                        <p class="m-b-0 col-sm-12 bold f-20 m-b-5">Title</p>
                                        <div class="col-sm-12">
                                            <input type="text" name="idea_title" class="input col-sm-12" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="m-b-0 col-sm-12 bold f-20">Your idea!</p>
                                        <div class="col-sm-12">
                                            <textarea name="idea" class="col-sm-12 input" cols="30" rows="8" placeholder="Describe your idea!"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-10">
                                    <div class="col-sm-12 d-flex jc-end">
                                        <button class="btn btn-inno m-r-20">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection