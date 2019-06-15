<? $expertises = \App\Expertises::select("*")->get();?>
<header class="headerShow no-select">
    @handheld
    <div class="p-t-10 container-fluid">
        @elsedesktop
        <div class="p-t-5 container-fluid">
            @endhandheld
            <div class="row desktopNav">
                <div class="col-sm-4">
                    <div class="pull-left d-flex m-t-30 m-l-15">
                        <div class="logoDiv">
                            <a class="td-none" href="/">
                                <img class="cartwheelLogo m-r-10" src="/images/cartwheel.png" alt="" style="width: 50px !important; height: 50px !important;">
                            </a>
                        </div>
                        <div class="m-b-20 m-t-5 searchBarBox m-l-20" style="min-width: 100px !important">
                            <div class="input-group mb-3 no-focus expertisesHeader <?= \App\Services\UserAccount\UserAccount::getTheme();?>">
                                <div class="input-group-prepend no-focus">
                                    <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20 active"></i></span>
                                </div>
                                <input style="outline: none !important; -webkit-appearance:none !important; width: 20vw !important" type="search" id="tagsHeader" class="form-control no-focus form-control-inno input-grey" placeholder="Search in tasks..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 text-center m-t-20">
                    <p class="thin f-20 m-b-5">Project progress</p>
                    <p class="f-20 m-0">20/120</p>
                </div>
                <div class="col-sm-4">
                    <div class="pull-right navBtns">
                        <div class="pull-right">

                        </div>
                    </div>
            </div>
        </div>
    </div>
</header>