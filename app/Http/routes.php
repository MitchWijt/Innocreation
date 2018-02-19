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

Route::get("/account", "UserController@userAccountCredentials");

Route::post("/my-account/saveUserAccount", "UserController@saveUserAccount");

Route::get("/my-account", "UserController@userAccountCredentials");

//User Expertises

Route::get("/my-account/expertises", "UserController@userAccountExpertises");

Route::post("/saveUserExpertiseDescription", "UserController@saveUserExpertiseDescription");

Route::post("/deleteUserExpertise","UserController@deleteUserExpertiseAction");

Route::post("/my-account/addUserExpertise","UserController@addUserExpertiseAction");

// Team info (benefits)

Route::get("/my-account/teamInfo", "UserController@teamBenefits");

// User Favorite Expertises

Route::get("/my-account/favorite-expertises", "UserController@favoriteExpertisesUser");

Route::post("/saveFavoriteExpertisesUser", "UserController@saveFavoriteExperisesUser");

Route::post("/deleteFavoriteExpertisesUser", "UserController@deleteFavoriteExpertisesUser");

Route::post("/filterFavExpertises", "UserController@filterFavExpertises");
// User Profile Picture

Route::post("/my-account/saveUserProfilePicture", "UserController@saveUserProfilePictureAction");

// User Portfolio
Route::get("/my-account/portfolio", "UserController@userAccountPortfolio");

Route::post("/my-account/saveUserPortfolio", "UserController@saveUseraccountPortfolio");

Route::post("/my-account/editUserPortfolio", "UserController@editUserPortfolio");

Route::post("/deleteUserPortfolio", "UserController@deleteUserPortfolio");
// User chats
Route::get("/my-account/chats", "UserController@userAccountChats");

Route::post("/searchChatUsers", "UserController@searchChatUsers");

Route::post("/selectChatUser", "UserController@selectChatUser");

Route::post("/sendMessageUser", "UserController@sendMessageUserAction");

// Create team for user
Route::post("/createTeam","UserController@createNewTeam");

Route::post("/favoriteTeam","UserController@favoriteTeamAction");

Route::post("/applyForTeam","UserController@applyForTeamAction");

Route::get("/my-account/team-join-requests","UserController@userTeamJoinRequestsAction");

Route::post("/postTeamReview","UserController@postTeamReviewAction");

//==============================SEARCHTEAMSPAGE========================

Route::get("/teams", "TeamSearchController@index");

Route::post("/team/searchTeams", "TeamSearchController@searchTeamsAction");
//==============================SINGLE PAGES==========================

Route::get("/team/{team_name}", "PageController@singleTeamPageIndex");

Route::get("/user/{firstname?}-{middlename?}-{lastname?}", "PageController@singleUserPageIndex");
//==============================TEAM===================================

Route::get("/my-team", "TeamController@teamPageCredentials");

Route::post("/my-team/saveTeamProfilePicture", "TeamController@saveTeamProfilePictureAction");

Route::post("/my-team/saveTeamPage", "TeamController@saveTeamPageAction");

Route::get("/my-team/neededExpertises", "TeamController@neededExpertisesAction");

Route::post("/my-team/addNeededExpertise", "TeamController@addNeededExpertiseAction");

Route::post("/my-team/saveNeededExpertise", "TeamController@saveNeededExpertiseAction");

Route::post("/my-team/deleteNeededExpertise", "TeamController@deleteNeededExpertiseAction");

Route::get("/my-team/user-join-requests", "TeamController@teamUserJoinRequestsAction");

Route::post("/my-team/rejectUserFromTeam", "TeamController@rejectUserFromTeamAction");

Route::post("/my-team/acceptUserInteam", "TeamController@acceptUserInteamAction");

Route::get("/my-team/members", "TeamController@teamMembersPage");

Route::post("/my-team/kickMemberFromTeam", "TeamController@kickMemberFromTeamAction");

Route::get("/my-team/team-chat", "TeamController@teamChatAction");

Route::post("/my-team/sendTeamMessage", "TeamController@sendTeamMessageAction");

Route::post("/my-team/muteMemberFromTeamChat", "TeamController@muteMemberFromTeamChatAction");

Route::post("/my-team/unmuteMemberFromTeamChat", "TeamController@unmuteMemberFromTeamChatAction");




