@extends("layouts.app")
@section("content")
<div class="home-background-wrapper">
    <div class="container">
        <div class="main-content">
            <div class="title-home">
                <h1 class="title-black text-center">Innocreation</h1>
                <div class="hr"></div>
                <p class="m-t-10 slogan text-center" style="color: #696969">Help each other make DREAMS become a reality</p>
            </div>
            <div class="circle">
                <i style="font-size: 50px; color: #FF6100" class="zmdi zmdi-chevron-down social-icon-home scrollHomeBtn"></i>
            </div>
        </div>
    </div>
    <div class="homepage-mainContent hidden">
        <div class="instructions">
            <div class="container">
                <div class="sub-title-container p-t-20">
                    <h1 id="scrollToHome" class="sub-title">How it works</h1>
                </div>
                <div class="hr"></div>
                <div class="row instructions-flex">
                    <div class="circle-instructions">
                        <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-accounts-outline social-icon-instructions"></i>
                    </div>
                    <p class="instructions-text m-0">Create an <a class="regular-link" href="/">account</a> with your expertise(s)</p>
                </div>
                <div class="row instructions-flex-right">
                    <p class="instructions-text m-b-0 m-r-20">Have an idea or product you want to develop</p>
                    <div class="circle-instructions">
                        <i style="font-size: 50px; color: #C9CCCF; padding-top: 9px; padding-left: 3px;" class="zmdi zmdi-developer-board social-icon-instructions"></i>
                    </div>
                </div>
                <div class="row instructions-flex">
                    <div class="circle-instructions">
                        <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-pin-drop social-icon-instructions"></i>
                    </div>
                    <p class="instructions-text m-0">Offer yourself as a service or ask for a service</p>
                </div>
                <div class="row instructions-flex-right p-b-20">
                    <p class="instructions-text m-b-0 m-r-20">Create or join a <a class="regular-link" href="/">team</a> and enjoy working together!</p>
                    <div class="circle-instructions">
                        <i style="font-size: 50px; color: #C9CCCF; padding-top: 12px; padding-left: 3px;" class="zmdi zmdi-badge-check social-icon-instructions"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="instructions-second ">
            <div class="container">
                <div class="row instructions-flex p-t-20">
                    <div class="circle-instructions">
                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">lightbulb_outline</i>
                    </div>
                    <p class="instructions-second-text m-0">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/">forum</a></p>
                </div>
                <div class="row instructions-flex-right ">
                    <p class="instructions-second-text m-b-0 m-r-20">Communicate easily with your team through the <a class="regular-link" href="/">chat system</a></p>
                    <div class="circle-instructions">
                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons social-icon-instructions">chat</i>
                    </div>
                </div>
                <div class="row instructions-flex m-t-20">
                    <div class="circle-instructions">
                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">attach_money</i>
                    </div>
                    <p class="instructions-second-text m-0">Pay all your team members with one push on a button</p>
                </div>
                <div class="row instructions-flex-right">
                    <p class="instructions-second-text m-b-0 m-r-20">Sell your own team products in our <a class="regular-link" href="/">shop</a></p>
                    <div class="circle-instructions">
                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons social-icon-instructions">shopping_basket</i>
                    </div>
                </div>
                <div class="row instructions-flex p-b-20">
                    <div class="circle-instructions">
                        <i style="font-size: 50px; padding-left: 1px;" class="fa fa-btc social-icon-instructions"></i>
                    </div>
                    <p class="instructions-second-text m-0">We support bitcoin and other cryptocurrencies</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footerView"></div>
</div>


<script>
    $(document).on( 'DOMMouseScroll mousewheel', function ( event ) {
        if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) {
            $(".headerShow").fadeIn();
            $(".home-background-wrapper").css("height","85vh");
            $(".homepage-mainContent").show();
            $(".footerView").load("/includes/footer");
        }
    });

    $(document).ready(function () {
        $('.headerShow').hide();
    });

    $(".scrollHomeBtn").click(function() {
        $(".headerShow").fadeIn();
        $(".home-background-wrapper").css("height","85vh");
        $(".homepage-mainContent").show();
        $(".footerView").load("/includes/footer");

        $('html, body').animate({
            scrollTop: $("#scrollToHome").offset().top - 120
        }, 2000);
    })
</script>
@endsection