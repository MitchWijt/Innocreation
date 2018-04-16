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

Route::post("/postTeamReview","UserController@postTeamReviewAction");

// invites and join requests
Route::post("/applyForTeam","UserController@applyForTeamAction");

Route::get("/my-account/team-join-requests","UserController@userTeamJoinRequestsAction");

Route::post("/my-account/acceptTeamInvite","UserController@acceptTeamInviteAction");

Route::post("/my-account/rejectTeamInvite","UserController@rejectTeamInviteAction");


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

Route::post("/my-team/inviteUserForTeam", "TeamController@inviteUserForTeamAction");

Route::get("/my-team/members", "TeamController@teamMembersPage");

Route::post("/my-team/kickMemberFromTeam", "TeamController@kickMemberFromTeamAction");

Route::get("/my-team/team-chat", "TeamController@teamChatAction");

Route::post("/my-team/sendTeamMessage", "TeamController@sendTeamMessageAction");

Route::post("/addUsersToGroupChat", "TeamController@addUsersToGroupChatAction");

Route::post("/removeUserFromGroupChat", "TeamController@removeUserFromGroupChatAction");

Route::post("/saveGroupChatTeam", "TeamController@saveGroupChatTeamAction");

Route::post("/deleteGroupChatTeam", "TeamController@deleteGroupChatTeamAction");

Route::post("/my-team/createGroupChat", "TeamController@createGroupChatAction");

Route::post("/my-team/sendMessageTeamGroupChat", "TeamController@sendMessageTeamGroupChatAction");

Route::post("/my-team/uploadProfilePictureTeamGroupChat", "TeamController@uploadProfilePictureTeamGroupChatAction");

Route::post("/my-team/muteMemberFromTeamChat", "TeamController@muteMemberFromTeamChatAction");

Route::post("/my-team/unmuteMemberFromTeamChat", "TeamController@unmuteMemberFromTeamChatAction");

Route::post("/my-team/editMemberPermissions", "TeamController@editMemberPermissionsAction");


//==============================WORKSPACE TEAM===================================


Route::get("/my-team/workspace", "WorkspaceController@index");

//Ideas

Route::get("/my-team/workspace/ideas", "WorkspaceController@workplaceIdeasAction");

Route::post("/workspace/changeIdeaStatus", "WorkspaceController@changeIdeaStatusAction");

Route::post("/workspace/addNewIdea", "WorkspaceController@addNewIdeaAction");

//Bucketlist

Route::get("/my-team/workspace/bucketlist", "WorkspaceController@workplaceBucketlistAction");

Route::post("/workspace/addNewBucketlistGoal", "WorkspaceController@addNewBucketlistGoalAction");

Route::post("/workspace/addBucketlistBoard", "WorkspaceController@addBucketlistBoardAction");

Route::post("/workspace/completeBucketlistGoal", "WorkspaceController@completeBucketlistGoalAction");

Route::post("/workspace/deleteBucketlistBoard", "WorkspaceController@deleteBucketlistBoardAction");

Route::post("/workspace/renameBucketlistBoard", "WorkspaceController@renameBucketlistBoardAction");

Route::post("/workspace/changePlaceBucketlistGoal", "WorkspaceController@changePlaceBucketlistGoalAction");

Route::post("/workspace/deleteSingleBucketlistGoal", "WorkspaceController@deleteSingleBucketlistGoalAction");

// Short term planner task planner

Route::get("/my-team/workspace/short-term-planner-options", "WorkspaceController@workspaceShortTermPlannerOptionPicker");

Route::post("/workspace/addNewShortTermPlannerBoard", "WorkspaceController@addNewShortTermPlannerBoardAction");

Route::get("/my-team/workspace/short-term-planner/{id}", "WorkspaceController@workspaceShortTermPlannerBoard");

Route::post("/workspace/addShortTermPlannerTask", "WorkspaceController@addShortTermPlannerTaskAction");

Route::post("/workspace/setShortTermPlannerTaskDueDate", "WorkspaceController@setShortTermPlannerTaskDueDateAction");

Route::post("/workspace/removeShortTermPlannerTaskDueDate", "WorkspaceController@removeShortTermPlannerTaskDueDateAction");

Route::post("/workspace/assignTaskToMemberShortTermPlanner", "WorkspaceController@assignTaskToMemberShortTermPlannerAction");

Route::post("/workspace/changePlaceShortTermPlannerTask", "WorkspaceController@changePlaceShortTermPlannerTaskAction");

Route::post("/workspace/menuTaskToShortTermPlanner", "WorkspaceController@menuTaskToShortTermPlannerAction");

Route::post("/workspace/changeShortTermPlannerBoardTitle", "WorkspaceController@changeShortTermPlannerBoardTitleAction");

Route::post("/workspace/saveShortTermPlannerTaskDescription", "WorkspaceController@saveShortTermPlannerTaskDescriptionAction");

Route::post("/workspace/deleteShortTermPlannerTask", "WorkspaceController@deleteShortTermPlannerTaskAction");

Route::post("/workspace/completeShortTermPlannerTask", "WorkspaceController@completeShortTermPlannerTaskAction");

Route::post("/workspace/setPriorityShortTermPlannerTask", "WorkspaceController@setPriorityShortTermPlannerTaskAction");

// Personal task board

Route::get("/my-team/workspace/my-tasks", "WorkspaceController@workspacePersonalBoard");

Route::post("/workspace/completeTaskPersonalBoard", "WorkspaceController@completeTaskPersonalBoardAction");

Route::post("/workspace/uncompleteTaskPersonalBoard", "WorkspaceController@uncompleteTaskPersonalBoardAction");

// Assistance tickets

Route::post("/workspace/askForAssistance", "WorkspaceController@askForAssistanceAction");

Route::get("/my-team/workspace/assistance-requests", "WorkspaceController@workspaceAssistanceTickets");

Route::post("/workspace/sendAssistanceTicketMessage", "WorkspaceController@sendAssistanceTicketMessageAction");

Route::post("/workspace/completeAssistanceTicket", "WorkspaceController@completeAssistanceTicketAction");

Route::post("/workspace/deleteAssistanceTicket", "WorkspaceController@deleteAssistanceTicketAction");

// Dashboard

Route::get("/my-team/workspace/dashboard", "WorkspaceController@workspaceDashboard");

Route::post("/workspace/getRealtimeDataDashboard", "WorkspaceController@getRealtimeDataDashboardAction");

Route::post("/workspace/getRealtimeDataDashboardShortTermPlannerTasks", "WorkspaceController@getRealtimeDataDashboardShortTermPlannerTasksAction");

Route::post("/workspace/changeMostAssistanceTicketsCategory", "WorkspaceController@changeMostAssistanceTicketsCategoryAction");

Route::post("/workspace/getMemberTaskListData", "WorkspaceController@getMemberTaskListDataAction");

Route::post("/workspace/getDashboardFilteredData", "WorkspaceController@getDashboardFilteredDataAction");

Route::post("/workspace/filterShortTermPlannerDashboardData", "WorkspaceController@filterShortTermPlannerDashboardDataAction");

// Meetings

Route::get("/my-team/meetings", "WorkspaceController@workspaceMeetings");

Route::post("/workspace/addNewMeeting", "WorkspaceController@addNewMeetingAction");

Route::post("/workspace/editMeeting", "WorkspaceController@editMeetingAction");

Route::post("/workspace/deleteMeeting", "WorkspaceController@deleteMeetingAction");

//==============================FORUM===================================


Route::get("/forum", "ForumController@forums");

Route::get("/forum/topic/{id}", "ForumController@forumMainTopicThreads");

