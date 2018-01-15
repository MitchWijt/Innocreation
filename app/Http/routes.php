<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get("/","HomeController@index");

Route::get("/includes/footer","HomeController@footer");

Route::get("/login", "LoginController@index");

Route::post("/loginUser", "LoginController@login");

Route::post("/register", "LoginController@register");

Route::get("/logout", "LoginController@logout");

//========================USERACCOUNT================================

Route::get("/account", "UserController@userAccount");

Route::post("/my-account/saveUserAccount", "UserController@saveUserAccount");

Route::get("/my-account", "UserController@userAccountCredentials");

Route::get("/my-account/expertises", "UserController@userAccountExpertises");

Route::post("/saveUserExpertiseDescription", "UserController@saveUserExpertiseDescription");

Route::get("/my-account/teamInfo", "UserController@teamBenefits");

Route::get("/my-account/favorite-expertises", "UserController@favoriteExpertisesUser");

Route::post("/saveFavoriteExpertisesUser", "UserController@saveFavoriteExperisesUser");

Route::post("/editFavoriteExpertisesUser", "UserController@editFavoriteExpertisesUser");

Route::post("/filterFavExpertises", "UserController@filterFavExpertises");

Route::post("/my-account/saveUserProfilePicture", "UserController@saveUserProfilePictureAction");

Route::get("/my-account/portfolio", "UserController@userAccountPortfolio");

Route::post("/my-account/saveUserPortfolio", "UserController@saveUseraccountPortfolio");

Route::post("/createTeam","UserController@createNewTeam");

//==============================TEAM=====================================

Route::get("/my-team", "TeamController@index");

