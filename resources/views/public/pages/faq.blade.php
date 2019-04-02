@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Frequently asked questions</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <? if(count($errors) > 0){ ?>
                        <? foreach($errors->all() as $error){ ?>
                            <p class="c-orange"><?=$error?></p>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
            <hr class="m-b-20">
            <? foreach($faqTypes as $faqType) { ?>
                <? if(count($faqType->getFaqs()) > 0) { ?>
                    <h4><?= $faqType->title?></h4>
                    <hr>
                    <? foreach($faqType->getFaqs() as $faq) { ?>
                    <div class="row faq">
                        <div class="col-sm-12 d-flex js-center">
                            <div class="card-lg col-sm-11 m-t-20 m-b-20">
                                <div class="card-block m-t-10">
                                    <div class="row">
                                        <div class="col-sm-12 d-flex m-t-10 m-b-10">
                                            <div class="col-sm-10">
                                                <p><?= $faq->question?></P>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-inno answerFaq">Answer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade faqAnswerModal" id="faqAnswerModal" tabindex="-1" role="dialog" aria-labelledby="faqAnswerModal" aria-hidden="true" >
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <p><strong>Question:</strong><br> <?= $faq->question?></p>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Answer:</strong><br> <?= $faq->answer?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
                <? } ?>
            <? } ?>
        </div>
    </div>
    <style>
        .modal {
            text-align: center;
        }

        @media screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
            min-width: 800px !important;
        }
    </style>
@endsection
@section('pagescript')
    <script src="/js/pages/faq.js"></script>
@endsection