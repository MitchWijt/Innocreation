@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <input type="hidden" class="teamProjectId" value="<?= $teamProject->id?>">
        <? if(isset($activeTaskId) && isset($activeFolderId)) { ?>
            <input type="hidden" id="activeTaskId" value="<?= $activeTaskId?>">
            <input type="hidden" id="activeFolderId" value="<?= $activeFolderId?>">
        <? } else if(isset($activeFolderId)) { ?>
            <input type="hidden" id="activeFolderId" value="<?= $activeFolderId?>">
        <?}  ?>
        <?= view("public/teamProjects/shared/_sidebar", compact("teamProject"))?>
        <div class="taskContent m-t-20">

        </div>
    </div>
@endsection

@section('pagescript')
    <script defer async src="/js/teamProject/plannerIndex.js"></script>
@endsection
