@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Password forgotten</h1>
            </div>
            <div class="hr col-sm-12 m-b-20"></div>
            <div class="row d-flex js-center p-b-20">
                <div class="col-md-8">
                    <div class="card text-center">
                        <div class="card-block">
                            <div class="col-sm-12 p-10">
                                <p class="f-13 m-b-0">Please enter the email address associated with your account</p>
                                <p class="f-13 m-b-0">And we will send you an email with a password reset link</p>
                                <p class="f-13 m-b-10">Be aware the link expires after 1 hour</p>
                                <form action="/user/sendPasswordResetLink" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="email" name="email" placeholder="Email" class="input">
                                    <button class="btn btn-inno btn-sm">Send link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection