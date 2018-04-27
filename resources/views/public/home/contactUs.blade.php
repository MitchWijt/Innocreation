@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Contact us</h1>
            </div>
            <div class="hr col-sm-12"></div>
            @if(session('success'))
                <div class="alert alert-success m-b-20 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <form action="/home/sendContactForm" enctype="multipart/form-data" class="contactUsForm" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <div class="row d-flex js-center m-t-20">
                    <div class="col-sm-8 d-flex">
                        <div class="col-sm-4 p-0">
                            <input type="text" name="firstname" placeholder="First name" class="input col-sm-11 firstname" value="<? if(isset($user)) echo $user->firstname?>">
                        </div>
                        <div class="col-sm-4 p-0">
                            <input type="text" name="middlename" placeholder="Middle name" class="input col-sm-11" value="<? if(isset($user->middlename) && isset($user)) echo $user->middlename?>">
                        </div>
                        <div class="col-sm-4 p-0">
                            <input type="text" name="lastname" placeholder="Last name" class="input col-sm-11 pull-right lastname" value="<? if(isset($user)) echo $user->lastname?>">
                        </div>
                    </div>
                </div>
                <div class="row m-t-20 d-flex js-center">
                    <div class="col-sm-8 d-flex js-center p-0">
                        <div class="col-sm-12 text-center">
                            <input type="email" name="email" placeholder="Email" class="input col-sm-12 email" value="<? if(isset($user)) echo $user->email?>">
                        </div>
                    </div>
                </div>
                <div class="row m-t-20 d-flex js-center">
                    <div class="col-sm-8 d-flex js-center p-0">
                        <div class="col-sm-12 text-center">
                            <textarea name="contactMessage" placeholder="Your message..." class="input col-sm-12 message" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row d-flex js-center">
                    <div class="col-sm-8">
                      <ul class="fileName">

                      </ul>
                    </div>
                </div>
                <div class="row d-flex js-center fileUpload">
                    <div class="col-sm-8 d-flex js-between">
                        <input type="file" name="files" multiple class="hidden files">
                        <button class="btn btn-inno addFiles" type="button"><i class="zmdi zmdi-file-plus"></i> Add files</button>
                        <button class="btn btn-inno submitContactForm" type="button">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/home/contactUs.js"></script>
@endsection
