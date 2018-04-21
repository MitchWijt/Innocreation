<div class="d-flex" style="justify-content: flex-end">
<form action="/forum/searchInForum" method="post">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <input type="text" name="searchForumInput" class="input" placeholder="Search in the forum">
    <button class="btn btn-inno btn-sm" type="submit">Search <i class="zmdi zmdi-search"></i></button>
</form>
</div>