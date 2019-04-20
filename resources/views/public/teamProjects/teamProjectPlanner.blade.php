@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <input type="hidden" class="teamProjectId" value="<?= $teamProject->id?>">
        <?= view("public/teamProjects/shared/_sidebar")?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script defer async src="/js/teamProject/plannerIndex.js"></script>
@endsection