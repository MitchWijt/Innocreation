@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="userworkData m-t-20 grid-container <?= \App\Services\UserAccount\UserAccount::getTheme()?>" data-page="admin">

            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script defer async src="/js/userworkFeed/feed.js"></script>
@endsection