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
            </body>
        </div>
    </div>
@endsection