<div class="row">
    <div class="col-sm-12">
        <i class="c-dark-grey f-11">Active as:</i>
        <? foreach($expertises as $expertise) { ?>
        <p class="m-0"><?= $expertise->title?></p>
        <? } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <? if(\Illuminate\Support\Facades\Session::has("user_id")){ ?>
            <? if($user->team_id != null) { ?>
                <a href="<?= $user->team->getUrl()?>" target="_blank" class="btn btn-inno btn-sm pull-right">To team <i class="zmdi zmdi-long-arrow-right"></i></a>
            <? } else { ?>
                <div class="d-flex js-center m-t-10">
                    <form action="/feed/sendCreateTeamRequest" method="post">
                        <input type="hidden" name="sender_user_id" value="<?= \Illuminate\Support\Facades\Session::get("user_id")?>">
                        <input type="hidden" name="receiver_user_id" value="<?= $user->id?>">
                        <button type="submit" class="btn btn-inno btn-sm pull-right">Create a team with <?= $user->firstname ?><i class="zmdi zmdi-long-arrow-right"></i></button>
                    </form>
                </div>
            <? } ?>
        <? } else { ?>
            <a href="<?= $user->getUrl()?>" target="_blank" class="btn btn-inno btn-sm pull-right">To <?= $user->firstname?> <i class="zmdi zmdi-long-arrow-right"></i></a>
        <? } ?>
    </div>
</div>


