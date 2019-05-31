@extends("layouts.app")
@section("content")
    <div class="">
        <div class="grey-background vh85">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 d-flex js-center">
                        @include("includes.flash")
                    </div>
                </div>
                <div class="sub-title-container p-t-20 m-b-20">
                    <h1 class="sub-title-black m-b-0">All team projects</h1>
                </div>
                <hr class="m-b-20">
                <input type="hidden" class="userJS" value="1">
                <div class="text-center <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                    <button class="btn btn-inno-cta m-t-25 addNewProject">New project</button>
                </div>
                <div class="row allProjects">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script defer async src="/js/teamProject/plannerProjectsIndex.js"></script>
@endsection