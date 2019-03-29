<? if($pageType == "checkout") { ?>
    <h1 class="bold text-center">Login</h1>
<? } ?>

<form action="/loginUser" method="POST" class="loginForm <? if(isset($urlParameter)) echo "hidden"?>">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <? if(isset($url)) { ?>
        <input type="hidden" name="redirect_uri" value="<?= $url?>">
        <input type="hidden" name="token" value="<?= $token?>">
    <? } ?>
    <? if($pageType == "checkout") { ?>
        <input type="hidden" name="pageType" value="<?= $pageType?>">
        <input type="hidden" name="backlink" value="<?= $backlink?>">
    <? } ?>
    <div class="form-group d-flex js-center m-b-0 p-b-20">
        <div class="d-flex fd-column <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-9"?> m-t-20">
            <label class="m-0">Email</label>
            <input type="email" name="email" class="email input m-b-15">
            <label class="m-0">Password <a href="/password-forgotten" class="regular-link">Forgot?</a></label>
            <input type="password" name="password" class="password input">
            <div class="row m-t-20">
                <div class="col-sm-12">
                    <button class="btn btn-inno-cta pull-right btn-block">Log in</button>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-sm-12">
                    <? if($pageType == "clean") { ?>
                        <p class="m-t-10 m-b-0">Don't have an account? <a class="regular-link" href="/create-my-account">Sign up here!</a></p>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</form>