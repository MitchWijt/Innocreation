@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85 ">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Teams</h1>
            </div>
            <div class="hr p-b-20"></div>
            <div class="d-flex js-around p-b-20">
                <a class="btn btn-inno c-gray">Join a team</a>
                <a class="btn btn-inno c-gray">Create a team</a>
            </div>
            <div class="row d-flex js-center p-b-20">
                <div class="card card-lg text-center">
                    <div class="card-block">
                        <div class="sub-title-container p-t-20">
                            <h1 class="sub-title-black c-gray">Benefits</h1>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <ul class="instructions-list">
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Develop your ideas with your own team</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Build your own team with creative and smart people</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Getting your ideas or products out there</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Sell your own team products in the shop</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Be a team leader of your own team</p>
                           </li>
                           <li class="instructions-list-item">
                               <p class="instructions-text f-19 m-0 p-b-10">Pay out your members easily</p>
                           </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection