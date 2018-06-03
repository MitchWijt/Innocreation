@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.forum_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.forum_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Activity timeline</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <small><i class="zmdi zmdi-refresh-alt"></i> auto refresh</small>
                </div>
            </div>
            @include("public.forum.shared._searchbarForum")
            <hr class="col-ms-12 m-b-0">
            <div class="container">
                <ul class="timeline">

                </ul>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/forum/activityTimeline.js"></script>
@endsection