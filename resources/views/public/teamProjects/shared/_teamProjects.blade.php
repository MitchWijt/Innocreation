<? foreach($projects as $project) { ?>
    <div class="col-xl-4 m-t-10 singleProject">
        <a class="td-none" href="/my-team/project/<?= $project->slug?>">
            <div class="card userCard m-t-20 m-b-20">
                <div class="card-block p-relative c-pointer" data-url="/" style="min-height: 160px !important">
                    <div class="text-center">
                        <i class="zmdi zmdi-calendar c-black f-40 m-t-30"></i>
                    </div>
                    <div class="text-center m-t-5">
                        <span class="c-orange f-13 completedTasks">10/120</span>
                    </div>
                    <div class="o-hidden p-absolute c-black" style="white-space: nowrap; text-overflow: ellipsis; max-width: 130px; top: 78%; left: 50%; transform: translate(-50%, -50%); z-index: 200;">
                        <span class="c-black f-20 projectTitle"><?= $project->title?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
<? } ?>