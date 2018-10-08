@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Innocreation data</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 d-flex js-center">
                                <form action="/commercialData/exportDataCsv" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <p class="m-0">Start date</p>
                                            <input type="text" name="startDate" class="input datepicker dateStart">
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-0">End date</p>
                                            <input type="text" name="endDate" class="input datepicker dateEnd">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-inno pull-right btn-sm">Download .csv</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".dateStart").datepicker({
                weekStart: 1,
                autoclose: true,
                minDate: new Date()
            });
        });

        $('.dateStart').on("change",function () {
            var startDate = $(this).val();
            $(".dateEnd").datepicker({
                weekStart: 1,
                autoclose: true,
                minDate: startDate
            });
        });
    </script>
@endsection