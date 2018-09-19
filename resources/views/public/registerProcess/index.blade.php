@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="sub-title-container p-t-20">
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50"
                     aria-valuemin="0" aria-valuemax="100" style="width:20%">
                    10% Complete
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20">Who are you?</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9">
                                        <div class="row m-t-20">
                                            <div class="col-sm-4">
                                                <input type="text" placeholder="Your First name" class="firstname col-sm-12 input" name="firstname">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" placeholder="Your Middle name" class="middlename col-sm-12 input" name="middlename">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" placeholder="Your Last name" class="lastname col-sm-12 input" name="lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9">
                                        <div class="row m-t-10">
                                            <div class="col-sm-4">
                                                <input type="radio" name="" id="">
                                                <label for="Male" class="m-r-10">Male</label>

                                                <input type="radio" name="" id="" >
                                                <label for="Male" class="m-r-10">Female</label>

                                                <input type="radio" name="" id="">
                                                <label for="Male">Private</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection