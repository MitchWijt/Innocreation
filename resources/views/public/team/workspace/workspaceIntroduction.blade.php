@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.workspace_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.workspace_sidebar")
            @endmobile
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
                                <p class="instructions-text f-19 m-0 p-b-10">Plan upfront for the whole team in the short term task planner</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Keep track of your own taks in your personal task board</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Keep track of your team progress in the dashboard!</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="/my-team/workspace/short-term-planner-options" class="btn btn-inno btn-lg">Lets go to work!</a>
                </div>
            </div>
        </div>
    </div>
@endsection