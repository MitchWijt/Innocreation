@extends("layouts.app")
@section("content")
<div class="grey-background vh100" >
    <div class="container" style="position: absolute; top: 35%; left: 50%; transform: translateX(-50%) translateY(-50%);">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img style="width: 40%" src="/images/placeholder.png" alt="">
            </div>
        </div>
        <div class="sub-title-container p-t-20">
            <h1 class="sub-title-black" id="titleLogin"><? if(isset($urlParameter)) echo "Register"; else echo "Login"?></h1>
        </div>
        <? if(isset($urlParameter)) { ?>
            <div class="row d-flex js-center requiredFields">
                <i class="f-11 m-b-15">* required fields</i>
            </div>
        <? } else { ?>
            <div class="row d-flex js-center requiredFields" style="display: none !important">
                <i class="f-11 m-b-15">* required fields</i>
            </div>
        <? } ?>
        <? if(isset($error)) { ?>
            <p class="c-orange text-center"><?=$error?></p>
        <? } ?>
        <? if(count($errors) > 0){ ?>
            <? foreach($errors->all() as $error){ ?>
                <p class="c-orange text-center"><?=$error?></p>
            <? } ?>
        <? } ?>
        <?
            if(isset($urlParameter)){
                if(isset($url)){
                    echo view("/public/shared/_loginRegister", compact("countries", "expertises", "urlParameter", "pageType", "url", "token"));
                } else {
                    echo view("/public/shared/_loginRegister", compact("countries", "expertises", "urlParameter", "pageType"));
                }
            } else {
                if(isset($url)){
                    echo view("/public/shared/_loginRegister", compact("countries", "expertises", "pageType", "url", "token"));
                } else {
                    echo view("/public/shared/_loginRegister", compact("countries", "expertises", "pageType"));
                }
            }
        ?>
    </div>
</div>

<script>
    $('#tokenfield').tokenfield({
        autocomplete: {
            source: [
                <? foreach($expertises as $expertise) { ?>
                    <? $title = $expertise->title?>
                    <? if(strpos($expertise->title,"-") !== false) {
                        $title = str_replace("-"," ",$title);
                     } ?>
                    <?= "'$title'"?>,
                <? } ?>
            ],
            delay: 100
        },
        showAutocompleteOnFocus: true,
        createTokensOnBlur: true
    });
</script>
@endsection
@section('pagescript')
    <script src="/js/login.js"></script>
@endsection