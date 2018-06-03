@notmobile
    <div class="sidebar">
        <hr class="m-t-0">
        <div class="sidebar-tab text-center">
            <a class="regular-link c-gray" href="/forum">Forums</a>
        </div>
        <hr>
        <div class="sidebar-tab text-center">
            <a class="regular-link c-gray" href="/page/forum-guidelines">Guidelines</a>
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
@elsemobile
    <i class="zmdi zmdi-view-toc f-25 m-t-10 toggleSidebar" data-toggle="modal" data-target=".sidebarModal"></i>
    <div class="modal fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body d-flex js-center">
                    <div class="sidebar">
                        <hr class="m-t-0">
                        <div class="sidebar-tab text-center">
                            <a class="regular-link c-gray" href="/forum">Forums</a>
                        </div>
                        <hr>
                        <div class="sidebar-tab text-center">
                            <a class="regular-link c-gray" href="/page/forum-guidelines">Guidelines</a>
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
                </div>
            </div>
        </div>
    </div>
@endnotmobile
