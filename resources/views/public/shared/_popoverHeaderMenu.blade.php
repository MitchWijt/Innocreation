<? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
    <div class="sidebar-tab m-b-5">
        <a class="regular-link c-gray" href="/what-is-innocreation">About us</a>
    </div>
    <div class="sidebar-tab m-b-5">
        <a class="regular-link c-gray" href="/pricing">Pricing</a>
    </div>
    <div class="sidebar-tab m-b-5">
        <a class="regular-link c-gray" href="/logout">Logout</a>
    </div>
<? } else { ?>
    <div class="sidebar-tab m-b-5">
        <a class="regular-link c-gray" href="/what-is-innocreation">About us</a>
    </div>
    <div class="sidebar-tab m-b-5">
        <a class="regular-link c-gray" href="/pricing">Pricing</a>
    </div>
<? } ?>
