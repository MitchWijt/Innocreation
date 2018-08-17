@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <body onload="init();" style="margin:0px;">
            <div id="animation_container" style="background-color:rgba(201, 204, 207, 1.00); width:1140px; height:700px">
                <canvas id="canvas" width="1140" height="700" style="position: absolute; display: block; background-color:rgba(201, 204, 207, 1.00);"></canvas>
                <div id="dom_overlay_container" style="pointer-events:none; overflow:hidden; width:1140px; height:700px; position: absolute; left: 0px; top: 0px; display: block;">
                </div>
            </div>
            <div class="text-center">
            <p class="f-18"><span class="f-25">Oops!</span> This page doesn't seem to want to collaborate with you and/or your team. To help you  <a href="/" class="btn btn-inno"><i class="zmdi zmdi-home"></i> Return to home!</a></p>
            </div>
            </body>
        </div>
    </div>
@endsection