@section("header")
    <header class="headerShow">
        @handheld
            <div class="p-t-10 container">
        @elsedesktop
            <div class="p-t-5 container-fluid">
        @endhandheld
            <div class="row">
                <div class="col-md-4 m-t-5 p-0">
                    <a class="td-none" href="/">
                        @handheld
                        @tablet
                        <div class="main-title">
                            <h1 class="title c-gray f-31">Inn<img class="cartwheelLogo-tablet" src="/images/cartwheel.png" alt="">creation</h1>
                            <p class="slogan f-9">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                        </div>
                        @elsemobile
                        <div class="main-title">
                            <h1 class="title c-gray f-40">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                            <p class="slogan f-12">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                        </div>
                        @endtablet
                        @elsedesktop
                        <div class="main-title">
                            <h1 class="title c-gray">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                            <p class="slogan">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                        </div>
                        @endhandheld
                    </a>
                </div>
            @desktop
                <div class="col-md-4 m-t-35 p-0">
            @elsemobile
                <div class="col-md-4 m-t-10 p-0">
            @enddesktop
            </div>
            @mobile
                <div class="col-md-6"></div>
            @elsedesktop
                <div class="col-md-4 p-0">
                    @tablet
                        <div class="d-flex jc-end">
                    @elsedesktop
                        <div class="d-flex jc-end m-t-10">
                    @endtablet
                        </div>
                    </div>
                    @endmobile
                    </div>
                    </div>
                    @mobile

                    @elsedesktop

                    @endmobile
                </div>
    </header>