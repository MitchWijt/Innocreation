<div class="sidebar">
    <div class="text-center">
        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("user_name")?></p>
        <span class="c-orange f-12 m-0">(expertises)</span>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account">My Profile</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/expertises">Expertises</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <? if(\Illuminate\Support\Facades\Session::has("team_id")) { ?>
            <a class="regular-link c-gray" href="/my-team">Team</a>
        <? } else { ?>
            <a class="regular-link c-gray" href="/my-account/teamInfo">Team</a>
        <? } ?>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/favorite-expertises">Favorite expertises</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="">My support tickets</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="">Recent transactions</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/team-join-requests">Join requests</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/portfolio">My portfolio</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/chats">Chat</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="">Favorite teams</a>
    </div>
    <hr>
</div>
