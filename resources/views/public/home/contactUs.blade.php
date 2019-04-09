@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black m-b-0">Contact us</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center m-b-10">
                    <small>You can also send a message in your account to the chat "Innocreation"!</small>
                </div>
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
                    <div class="col-sm-12 d-flex">
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
                    <div class="col-sm-12 d-flex js-center p-0">
                        <div class="col-sm-12 text-center">
                            <input type="email" name="email" placeholder="Email" class="input col-sm-12 email" value="<? if(isset($user)) echo $user->email?>">
                        </div>
                    </div>
                </div>
                <div class="row m-t-20 d-flex js-center">
                    <div class="col-sm-12 d-flex js-center p-0">
                        <div class="col-sm-12 text-center">
                            <textarea name="contactMessage" placeholder="Your message..." class="input col-sm-12 message" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row m-b-20 d-flex js-center">
                    <div class="col-sm-8 p-l-15">
                        <div class="g-recaptcha" data-sitekey="6LfW7G4UAAAAAOJvDkQiKgOONaSkHIE4vEjuWJg3"></div>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-inno submitContactForm pull-right" type="button">Send</button>
                    </div>
                </div>
                <div class="row d-flex js-center fileUpload">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <i class="zmdi zmdi-whatsapp f-25 c-green"></i> <span class="f-25">/</span> <i class="zmdi zmdi-phone f-20"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="m-t-5">+31633373476</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <i class="zmdi zmdi-mail-send f-25"></i>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="">info@innocreation.net</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/home/contactUs.js"></script>
@endsection
