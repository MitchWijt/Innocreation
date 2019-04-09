<div class="row p-relative d-flex js-center">
    @mobile
    <i class="zmdi zmdi-close f-18 c-orange p-absolute closePopover" style="top: 5px !important; right: 15px!important; z-index: 10 !important;"></i>
    @endmobile
    <div class="d-flex js-center">
        <div class="col-sm-12">
            <form action="/my-team/kickMemberFromTeam" class="m-b-0" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="user_id" value="<?= $member->id?>">
                <input type="hidden" name="team_id" value="<?= $team->id?>">
                <button class="btn btn-inno btn-danger btn-sm" type="submit">Kick member</button>
            </form>
        </div>
    </div>
</div>


