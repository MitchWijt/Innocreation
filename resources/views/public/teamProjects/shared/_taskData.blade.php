<link rel="stylesheet" href="/css/selects/custom-select-clean.css">
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
<div class="row m-t-20">
    <div class="col-sm-8">
        <div class="row m-l-5">
            <div class="col-sm-6">
                <div class="row d-flex">
                    <div class="custom-select col-sm-3 font p-b-0 m-t-5">
                        <select name="fontStyle" class="fontStyle">
                            <option value="Verdana">Verdana</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Comic Sans">Comic Sans</option>
                            <option value="Trebucket">Trebucket</option>
                            <option value="Arial black">Arial black</option>
                            <option value="Impact">Impact</option>
                            <option value="Helvetica">Helvetica</option>
                            <option value="Corbert" selected>Corbert</option>
                        </select>
                    </div>
                    <div class="custom-select col-sm-2 fontSize p-b-0 m-t-5">
                        <select name="fontSize" class="fontSize">
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14" selected>14</option>
                            <option value="18">18</option>
                            <option value="24">24</option>
                            <option value="36">36</option>
                            <option value="48">48</option>
                            <option value="64">64</option>
                            <option value="72">72</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4 d-flex m-t-20">
                        <i class="zmdi zmdi-format-bold f-14 m-r-10 c-pointer c-black"></i>
                        <i class="zmdi zmdi-format-italic f-14 m-r-10 c-pointer c-black"></i>
                        <i class="zmdi zmdi-format-underlined f-14 c-pointer c-black"></i>
                    </div>
                    <div class="col-sm-4 d-flex m-t-20">
                        <i class="zmdi zmdi-format-color-text f-14 m-r-10 c-pointer c-black"></i>
                        <i class="zmdi zmdi-code f-14 c-pointer c-black"></i>
                    </div>
                    <div class="col-sm-4 d-flex m-t-15">
                        <span><i class="zmdi zmdi-format-list-bulleted f-14 m-r-10 c-pointer c-black" style="margin-top: 6px;"></i></span>
                        <span><i class="zmdi zmdi-format-list-numbered f-14 c-pointer c-black" style="margin-top: 6px; margin-right: 6px;"></i></span>
                        <i class="c-black"><?= \App\Services\CustomIconService::getIcon("checkbox-list", "18px");?></i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<hr>
<div class="col-sm-12 m-l-10 m-t-5">
    <input type="text" class="input-transparant titleTask c-black f-40 bold" data-task-id="<?= $taskData->task->id?>" value="<?= $taskData->task->title?>">
    <div contenteditable="true" class="col-sm-12 taskContentEditor m-l-0 p-l-0 m-t-10 no-focus" data-task-id="<?= $taskData->task->id?>">
        <?= $taskData->task->content?>
    </div>
</div>
<script defer async src="/js/assets/customSelect.js"></script>
<?//= dd($taskData)?>