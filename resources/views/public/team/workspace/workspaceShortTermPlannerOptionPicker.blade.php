@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Choose your option</h1>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center p-b-20">
                <div class="col-sm-12 d-flex">
                    <div class="col-sm-4">
                        <div class="card card-square-sm text-center">
                            <div class="card-block">
                                <p class="f-20 m-t-30">Day planner</p>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card card-square-sm text-center">
                            <div class="card-block">
                                <p class="f-20 m-t-30">Week planner</p>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card card-square-sm text-center hover">
                            <div class="card-block">
                                <p class="f-20 m-t-30">Month planner</p>
                                <hr>
                                <ul class="instructions-list">
                                    <li class="instructions-list-item">
                                        <p class="instructions-text f-13 m-0 p-b-10">Choose your plan and name it</p>
                                    </li>
                                    <li class="instructions-list-item">
                                        <p class="instructions-text f-13 m-0 p-b-10">You can pick more create more plans later on</p>
                                    </li>
                                    <li class="instructions-list-item">
                                        <p class="instructions-text f-13 m-0 p-b-10">Make your team even more efficient</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center p-b-20">
                <div class="card card-lg text-center">
                    <div class="card-block m-t-20">
                        <ul class="instructions-list">
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Choose your plan and name it</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">You can create more plans later on</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Make your team even more efficient</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection