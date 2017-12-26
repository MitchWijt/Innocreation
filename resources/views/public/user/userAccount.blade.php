@extends("layouts.app")
@section("content")
    <div class="userAccountMain d-flex grey-background" style="height: 70vh;">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <h1><?=$user->firstname?></h1>
        </div>
    </div>
@endsection