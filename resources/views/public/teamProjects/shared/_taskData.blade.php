<div class="row">
    <div class="col-sm-8">
        <div class="row m-l-5">
            <div class="col-sm-3">
                <i class="zmdi zmdi-folder-outline c-black f-25 m-r-10"></i><?= $taskData->folder->title?>
            </div>
            <div class="col-sm-3">
                <i class="zmdi zmdi-account-o c-black f-25 m-r-10"></i><span class="thin">Assign to member</span>
            </div>
            <div class="col-sm-3">
                <i class="zmdi zmdi-time c-black f-25 m-r-10"></i><span class="thin">Add due date</span>
            </div>
            <div class="col-sm-3">
                <div class="d-flex">
                    <div>
                        <?= \App\Services\CustomIconService::getIcon("tag-outline")?>
                    </div>
                    <input type="text" class="input-transparant c-black m-l-5" placeholder="Add label...">
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

<?//= dd($taskData)?>