@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between">
                                <h4 class="m-t-5">Service reviews</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="m-t-20 col-sm-12">
                                <table  id="table" class="display">
                                    <thead>
                                    <tr>
                                        <th scope="col" data-column-id="id" data-visible="false" data-type="numeric">ID</th>
                                        <th scope="col">User</th>
                                        <th scope="col" data-column-id="name">Category</th>
                                        <th scope="col" data-column-id="name">rating</th>
                                        <th scope="col" data-column-id="name">review</th>
                                        <th scope="col" data-column-id="name">description</th>
                                        <th scope="col" data-formatter="date">Created at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($serviceReviews as $serviceReview) { ?>
                                        <tr>
                                            <td scope="row" data-visible="false"><?= $serviceReview->id?></td>
                                            <td><?= $serviceReview->users->firstname?></td>
                                            <td><?= $serviceReview->serviceReviewType->title?></td>
                                            <td><?= $serviceReview->rating?></td>
                                            <td><?= $serviceReview->review?></td>
                                            <td><?= $serviceReview->review_description?></td>
                                            <td><?= date("d-m-Y",strtotime($serviceReview->created_at))?></td>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>
@endsection