@extends("layouts.app")
@section("content")
<div class="grey-background" style="min-height: 80vh;">
    <div class="container">
        <div class="sub-title-container p-t-20">
            <h1 id="scrollToHome" class="sub-title-black">Login</h1>
        </div>
        <div class="hr"></div>
        <form action="" method="POST">
            <div class="form-group d-flex js-center m-b-0 p-b-20">
                <div class="d-flex fd-column col-sm-9">
                    <label class="m-0">Username</label>
                    <input type="text" name="username" class="username input">
                    <label class="m-0">Password</label>
                    <input type="password" name="password" class="password input">
                    <div class="row m-t-20">
                        <div class="col-sm-12">
                            <button class="btn btn-inno pull-right">Log in</button>
                            <p class="m-t-10">Don't have an account? <a class="regular-link" href="">Sign up here!</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection