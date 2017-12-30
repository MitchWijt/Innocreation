@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background" style="height: 70vh;">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <h1><?=$user->firstname?></h1>
            {{--WILL BE YOUR EXPERTISES. IF YOU ARE IN A TEAM IT WILL BE YOUR TEAM--}}
        </div>
    </div>
@endsection