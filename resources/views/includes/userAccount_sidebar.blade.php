<?
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
?>
@notmobile
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
        <? if($user->team_id != null) { ?>
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
        <a class="regular-link c-gray" href="/my-account/support-tickets">My support tickets</a>
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
@elsemobile
<i class="zmdi zmdi-view-toc f-25 m-t-10 toggleSidebar" data-toggle="modal" data-target=".sidebarModal"></i>
<div class="modal fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex js-center">
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
                        <? if($user->team_id != null) { ?>
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
                        <a class="regular-link c-gray" href="/my-account/support-tickets">My support tickets</a>
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
            </div>
        </div>
    </div>
</div>
@endnotmobile
