@extends("layouts.app")
@section("content")
    <script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8215323598983147.shtml"></script>
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Payment details</h1>
            </div>
            <div class="hr p-b-20 col-md-10"></div>
            <? foreach($splitTheBillDetails as $splitTheBillDetail) { ?>
                <div class="row d-flex js-center p-b-20">
                    <div class="col-md-10">
                        <div class="card card-lg">
                            <div class="card-block">
                                <div class="row m-t-20 m-b-20">
                                    <div class="col-sm-10">
                                        <p class="m-l-10"><a target="_blank" href="<?= $splitTheBillDetail->team->getUrl()?>" class="regular-link"><?= $splitTheBillDetail->team->team_name?></a> has asked you to accept and validate the "split the bill". Since you are a member of this team. Validate as soon as possible to enjoy the benefits of your package even quiker!</p>
                                    </div>
                                    <div class="col-sm-2 m-t-10">
                                        <? if($splitTheBillDetail->user->encrypted_credit_card != null && $splitTheBillDetail->accepted == 1) { ?>
                                            <p class="c-green">Validated <i class="zmdi zmdi-check c-green"></i> </p>
                                        <? } else { ?>
                                            <button data-toggle="collapse" href="#collapse-<?= $splitTheBillDetail->id?>" class="btn btn-inno pull">Validate</button>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                            $date = date("Y-m-d");
                            $time = date("H:i:s");
                        ?>
                        <div id="collapse-<?= $splitTheBillDetail->id?>" class="collapse">
                            <div class="card card-lg">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <form method="POST" class="m-t-20" action="/user/validateSplitTheBill" id="adyen-encrypted-form">
                                                <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                <div class="row d-flex js-center">
                                                    <div class="col-sm-3">
                                                        <input type="text" class="input col-sm-12" placeholder="Card number" size="20" data-encrypted-name="number"/>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="input col-sm-12" placeholder="Holdername" size="20" data-encrypted-name="holderName"/>
                                                    </div>
                                                </div>
                                                <div class="row m-t-10 d-flex js-center">
                                                    <div class="col-sm-2">
                                                        <input type="text" class="input col-sm-12" placeholder="<?= date("m")?>" size="2" data-encrypted-name="expiryMonth"/>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="input col-sm-12" placeholder="<?= date("Y")?>" size="4" data-encrypted-name="expiryYear"/>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="input col-sm-12" placeholder="cvc" size="4" data-encrypted-name="cvc"/>
                                                    </div>
                                                </div>
                                                <div class="row d-flex js-center m-t-10">
                                                    <div class="col-sm-6 d-flex jc-end">
                                                        <input type="checkbox" value="1" class="m-t-5" name="paymentTermsCheck" id="paymentTermAgree"><label for="paymentTermAgree" class="m-l-5"> I agree with the terms of payment</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="<?=$date?>T<?=$time?>Z" data-encrypted-name="generationtime"/>
                                                <div class="row m-t-10 m-b-20">
                                                    <div class="col-sm-9">
                                                        <input type="submit" class="btn btn-inno btn-sm pull-right" value="Validate"/>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-3 m-t-20 text-center">
                                            <p class="f-20 m-t-0"><? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo "Innovator(custom package)"; else echo str_replace("-", " ", ucfirst($teamPackage->title))?></p>
                                            <p style="letter-spacing: 1px;"><?= "&euro;" . number_format($splitTheBillDetail->amount, 2, ".", ".")?><span style="letter-spacing: 0px;">/Month</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
    <script>
        // The form element to encrypt.
        var form = document.getElementById('adyen-encrypted-form');
        // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
        var options = {};
        // Bind encryption options to the form.
        adyen.createEncryptedForm(form, options);
    </script>
@endsection