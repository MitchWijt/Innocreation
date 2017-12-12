@extends("layouts/app")
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
                <i style="font-size: 50px; color: #FF6100" class="zmdi zmdi-chevron-down social-icon-home"></i>
            </div>
        </div>
    </div>
    <div class="homepage-mainContent hidden">
        <h1>  fhfhfhfh</h1>
        {{--CONTENT HERE--}}
    </div>
</div>


<script>
    $(document).on( 'DOMMouseScroll mousewheel', function ( event ) {
        if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) {
            $(".headerShow").fadeIn();
            $(".home-background-wrapper").css("height","85vh");
            $(".homepage-mainContent").show();
        }
    });
</script>
@endsection