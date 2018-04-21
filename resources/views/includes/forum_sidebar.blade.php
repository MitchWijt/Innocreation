<div class="sidebar">
    <hr class="m-t-0">
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/forum">Forums</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/forum/guidelines">Guidelines</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/forum/activity-timeline">Activity timeline</a>
    </div>
    <hr>
    <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
        <div class="sidebar-tab text-center">
            <a class="regular-link c-gray" href="/forum/my-following-topics">Topics I follow</a>
        </div>
        <hr>
    <? } ?>
</div>
