@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $team->team_name?> workspace</h1>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center p-b-20">
                <div class="card card-lg text-center">
                    <div class="card-block">
                        <div class="sub-title-container p-t-20">
                            <h1 class="sub-title-black c-gray">Introduction</h1>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <ul class="instructions-list">
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Post each others idea's in the idea tab</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Create your own team bucketlist or submit new goals</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Plan your entire day for the whole team in the short term planner</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Create your schedule for the upcomming months with the long term planner</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Keep track of your progress in the personal dashboard!</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-inno btn-lg">Lets go to work!</button>
                </div>
            </div>
        </div>
    </div>
@endsection