@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team products</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <? foreach($teamProducts as $teamProduct) { ?>
                <div class="row d-flex js-center m-t-20 m-b-20">
                    <div class="col-md-10">
                        <div class="card card-lg">
                            <div class="card-block @mobile p-10 @endmobile">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h2 class="p-t-10 m-b-0 @mobile f-25 @endmobile"><?= $teamProduct->title?></h2>
                                        <i class="c-dark-grey f-12">Created by <a target="_blank" class="regular-link" href="<?= $teamProduct->team->getUrl()?>"><?= $teamProduct->team->team_name?></a></i>
                                    </div>
                                </div>
                                @desktop
                                    <hr class="col-md-7">
                                @elsemobile
                                    <hr class="col-xs-12">
                                @enddesktop
                                <div class="row d-flex js-center m-t-15">
                                    <div class="col-md-7 text-center">
                                        <img class="col-sm-7 col-xs-12 p-0 radius img-responsive" src="/images/portfolioImages/pexels-photo-tiny-3 kopie.jpg" alt="">
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="col-sm-12">
                                        <p class="col-sm-12"><?= $teamProduct->description?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 m-l-15 m-b-5 socials">
                                        <? if(isset($user)) { ?>
                                            <? if($user->checkTeamProduct($teamProduct->id, "liked")) { ?>
                                                <span><i class="zmdi zmdi-favorite f-20 likedTeamProduct c-orange" data-id="<?= $teamProduct->id?>"></i></span>
                                            <? } else { ?>
                                                <span><i class="zmdi zmdi-favorite-outline f-20 likeTeamProduct" data-id="<?= $teamProduct->id?>"></i></span>
                                                <span><i class="zmdi zmdi-favorite f-20 likedTeamProduct c-orange hidden" data-id="<?= $teamProduct->id?>"></i></span>
                                        <? } ?>
                                            <span class="m-r-10 amountLikes"><?= $teamProduct->getLikes()?></span>
                                            <? if($user->checkTeamProduct($teamProduct->id, "favorite")) { ?>
                                                <span><i class="zmdi zmdi-star f-20 m-r-10 favoriteTeamProduct c-orange" data-id="<?= $teamProduct->id?>"></i></span>
                                            <? } else { ?>
                                                <span><i class="zmdi zmdi-star f-20 m-r-10 favoriteTeamProduct" data-id="<?= $teamProduct->id?>"></i></span>
                                            <? } ?>
                                            <span><i class="zmdi zmdi-share f-20 shareTeamProduct toggleModal" data-id="<?= $teamProduct->id?>" data-url="<?= $teamProduct->getUrl(true)?>"></i></span>
                                        <? } else { ?>
                                            <span><i class="zmdi zmdi-share f-20 shareTeamProduct toggleLink"></i></span>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <? if(isset($user)) { ?>
                <div class="modal fade shareTeamProductModal" id="shareTeamProductModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <? if($user->team_id != null) { ?>
                                    @desktop
                                        <div class="row d-flex js-center">
                                            <div class="col-md-12 text-center">
                                                <input type="radio" name="radio" id="user" class="shareWithUsersRadio input"><label for="user" class="m-r-30">Share with users</label>
                                                <input type="radio" name="radio" id="team" class="input shareWithTeam "><label for="team">Share with my team</label>
                                            </div>
                                        </div>
                                    @elsemobile
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <input type="radio" name="radio" id="user" class="shareWithUsersRadio input m-r-5"><label for="user" class="m-r-30">Share with users</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <input type="radio" name="radio" id="team" class="input shareWithTeam m-r-5"><label for="team">Share with my team</label>
                                            </div>
                                        </div>
                                    @endmobile
                                <? } ?>
                                <? if($user->team_id != null) { ?>
                                    <hr class="m-b-20 col-md-10">
                                <? } ?>
                                <form action="/feed/shareTeamProduct" class="shareTeamProductUsersForm" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="team_product_id" class="team_product_id" value="">
                                    <div class="shareWithUsers <? if($user->team_id != null) echo "hidden" ?>">
                                        <div class="row m-t-20">
                                            <div class="col-sm-6">
                                                <input type="text" name="searchUsers" placeholder="search users..." class="input m-r-5 searchUsersInput"><button type="button" class="btn btn-inno btn-sm searchUsers">Search</button>
                                                <div class="resultList m-b-20">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-0">Selected users:</p>
                                                <ul class="selectedUsers">

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shareProductMessage <? if($user->team_id != null) echo "hidden" ?>">
                                        <textarea name="shareProductMessage" class="col-sm-12 input message" rows="10"></textarea>
                                        <button class="btn btn-inno pull-right">Share product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/feed/teamProducts.js"></script>
@endsection