@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black m-b-0">Innocreatives</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i class="f-12 c-dark-grey">Post your best work/project for everyone to see!</i>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center userworkData">

            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/userworkFeed/index.js"></script>
@endsection