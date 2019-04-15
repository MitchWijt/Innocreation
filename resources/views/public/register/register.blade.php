@extends("layouts.app")
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme();?>">
        <div class="grey-background vh100">
            <div class="container <?= \App\Services\UserAccount\UserAccount::getTheme();?>">
                <?= view("/public/shared/_register", compact('countries', 'expertises'))?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/register/index.js"></script>
@endsection