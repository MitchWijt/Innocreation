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

Route::get("/debug/test", "DebugController@test");

Route::get("/includes/footer","HomeController@footer");

Route::get("/login", "LoginController@index");

Route::get("/invite/{hash?}/{teamName?}", "LoginController@index");

Route::post("/loginUser", "LoginController@login");

Route::post("/register", "LoginController@register");

Route::get("/logout", "LoginController@logout");

Route::get("/header", "HomeController@headerMail");

Route::get("/password-forgotten", "UserController@passwordForgottenIndex");

Route::post("/home/sendMoreInfoMail", "HomeController@sendMoreInfoMailAction");

Route::post("/home/getStatusUser", "HomeController@getStatusUserAction");

Route::post("/home/getModalCarouselUser", "HomeController@getModalCarouselUserAction");

Route::post("/home/searchExpertise", "HomeController@searchExpertiseAction");

Route::post("/openConnectionModal", "UserConnectionController@connectionsModalAction");

// CONTACT US
Route::get("/contact-us", "HomeController@contactAction");

Route::post("/home/sendContactForm", "HomeController@sendContactFormAction");

Route::get("/faq", "PageController@faqAction");





//========================NOTIFICATIONS================================
Route::post("/notification/getNotifications", "NotificationController@getNotificationsAction");

Route::post("/notification/getMessageNotifications", "NotificationController@getMessageNotificationsAction");

Route::post("/notification/toChat", "NotificationController@toChatAction");

Route::post("/notification/getTeamInvites", "NotificationController@getTeamInvitesAction");
//========================USERACCOUNT================================

Route::post("/my-account/saveUserAccount", "UserController@saveUserAccount");

Route::post("/user/sendPasswordResetLink", "UserController@sendPasswordResetLinkAction");

Route::get("/resetPassword/{hash}", "UserController@resetPasswordIndexAction");

Route::post("/user/resetPassword", "UserController@resetPasswordAction");

Route::post("/user/sendConnectRequest", "UserController@sendConnectRequestAction");

//User Expertises

Route::post("/user/saveUserExpertise", "UserController@saveUserExpertiseAction");

Route::post("/user/deleteUserExpertise","UserController@deleteUserExpertiseAction");

Route::post("/user/getEditUserExpertiseModal","UserController@getEditUserExpertiseModalAction");

Route::post("/user/editUserExpertiseImage","UserController@editUserExpertiseImage");

Route::post("/user/getEditExpertiseModal","UserController@getEditExpertiseModalAction");

Route::post("/user/loadMoreExpertises","UserController@loadMoreExpertises");

// Team info (benefits)

Route::get("/my-account/teamInfo", "UserController@teamBenefits");

// User Favorite Expertises

Route::get("/my-account/favorite-expertises", "UserController@favoriteExpertisesUser");

Route::post("/saveFavoriteExpertisesUser", "UserController@saveFavoriteExperisesUser");

Route::post("/deleteFavoriteExpertisesUser", "UserController@deleteFavoriteExpertisesUser");

Route::post("/filterFavExpertises", "UserController@filterFavExpertises");
// User Profile Picture

Route::post("/user/saveUserProfilePicture", "UserController@saveUserProfilePictureAction");

Route::post("/user/editBannerImage", "UserController@editBannerImageAction");


// User Portfolio
Route::get("/my-account/portfolio", "UserController@userAccountPortfolio");

Route::post("/user/addUserAccountPortfolio", "UserController@addUserAccountPortfolio");

Route::post("/my-account/editUserPortfolio", "UserController@editUserPortfolio");

Route::post("/user/savePortfolioAsUserWork", "UserController@savePortfolioAsUserWorkAction");

Route::post("/deleteUserPortfolio", "UserController@deleteUserPortfolio");

Route::get("/my-account/portfolio/{slug}", "UserController@userPortfolioDetail");

Route::post("/user/addImagesPortfolio", "UserController@addImagesPortfolio");

Route::post("/user/editTitlePortfolioImage", "UserController@editTitlePortfolioImage");

Route::post("/user/editDescPortfolioImage", "UserController@editDescPortfolioImage");

Route::post("/user/removePortfolioImage", "UserController@removePortfolioImage");

Route::post("/user/deletePortfolio", "UserController@deletePortfolio");

Route::post("/user/addImageToAudio", "UserController@addImageToAudio");

// User chats
Route::get("/my-account/chats", "UserController@userAccountChats");

Route::post("/searchChatUsers", "UserController@searchChatUsers");

Route::post("/selectChatUser", "UserController@selectChatUser");

Route::post("/sendMessageUser", "UserController@sendMessageUserAction");

Route::post("/user/deleteUserChat", "UserController@deleteUserChatAction");

Route::post("/user/removeChatSession", "UserController@removeChatSessionAction");

//Settings
Route::post("/user/openPrivacySettingsModal", "UserController@openPrivacySettingsModalAction");



// Create team for user
Route::post("/createTeam","UserController@createNewTeam");

Route::post("/favoriteTeam","UserController@favoriteTeamAction");

Route::post("/postTeamReview","UserController@postTeamReviewAction");

// invites and join requests
Route::post("/applyForTeam","UserController@applyForTeamAction");

Route::get("/my-account/team-join-requests","UserController@userTeamJoinRequestsAction");

Route::post("/my-account/acceptTeamInvite","UserController@acceptTeamInviteAction");

Route::post("/my-account/rejectTeamInvite","UserController@rejectTeamInviteAction");

//favorite teams
Route::get("/my-account/favorite-teams","UserController@favoriteTeamsAction");

Route::post("/user/joinTeamFromHelper","UserController@joinTeamFromHelperAction");

Route::post("/user/finishHelper","UserController@finishHelperAction");


//connections
Route::post("/user/acceptConnection","UserController@acceptConnectionAction");

Route::post("/user/declineConnection","UserController@declineConnectionAction");


//payments
Route::get("/my-account/payment-details", "UserController@paymentDetailsAction");

Route::post("/user/validateSplitTheBill", "UserController@validateSplitTheBillAction");

Route::get("/my-account/billing", "UserController@billingAction");

Route::post("/user/rejectChange", "UserController@rejectChangeAction");

Route::post("/user/validateChange", "UserController@validateChangeAction");

Route::post("/user/rejectSplitTheBill", "UserController@rejectSplitTheBillAction");

Route::post("user/cancelSubscription", "UserController@cancelSubscriptionAction");

//==============================SEARCHTEAMSPAGE========================

Route::get("/teams", "TeamSearchController@index");

Route::post("/team/searchTeams", "TeamSearchController@searchTeamsAction");
//==============================SINGLE PAGES==========================

Route::get("/team/{team_name}", "PageController@singleTeamPageIndex");

Route::get("/user/{slug?}", "PageController@singleUserPageIndex");
//==============================TEAM===================================

Route::get("/my-team", "TeamController@teamPageCredentials");

Route::post("/my-team/saveTeamProfilePicture", "TeamController@saveTeamProfilePictureAction");

Route::post("/my-team/saveTeamPage", "TeamController@saveTeamPageAction");

Route::post("/my-team/getPrivacySettingsModal", "TeamController@getPrivacySettingsModal");

Route::post("/my-team/editNeededExpertiseModal", "TeamController@editNeededExpertiseModal");

Route::get("/my-team/neededExpertises", "TeamController@neededExpertisesAction");

Route::post("/my-team/addNeededExpertise", "TeamController@addNeededExpertiseAction");

Route::post("/my-team/saveNeededExpertise", "TeamController@saveNeededExpertiseAction");

Route::post("/my-team/deleteNeededExpertise", "TeamController@deleteNeededExpertiseAction");

Route::get("/my-team/user-join-requests", "TeamController@teamUserJoinRequestsAction");

Route::post("/my-team/rejectUserFromTeam", "TeamController@rejectUserFromTeamAction");

Route::post("/my-team/acceptUserInteam", "TeamController@acceptUserInteamAction");

Route::post("/my-team/inviteUserForTeam", "TeamController@inviteUserForTeamAction");

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

Route::post("/my-team/saveTeamProduct", "TeamController@saveTeamProductAction");

Route::post("/my-team/getTeamProductModalData", "TeamController@getTeamProductModalDataAction");

Route::post("/my-team/deleteTeamProduct", "TeamController@deleteTeamProductAction");

Route::post("/my-team/generateInviteLink", "TeamController@generateInviteLinkAction");

Route::post("/my-team/saveNewName", "TeamController@saveTeamNameAction");

Route::post("/my-team/editBannerImage", "TeamController@editBannerImage");

Route::post("/team/getTeamLimitModal", "TeamController@getTeamLimitModal");



//Payment
Route::get("/my-team/payment-details", "TeamController@teamPaymentDetailsAction");

Route::get("/my-team/payment-settings", "TeamController@teamPaymentSettingsAction");

Route::post("/my-team/savePaymentSettings", "TeamController@savePaymentSettingsAction");


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

Route::post("/workspace/getBucketlistItemModal", "WorkspaceController@getBucketlistItemModalAction");

Route::post("/workspace/editBucketlistItemDescription", "WorkspaceController@editBucketlistItemDescriptionAction");

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

Route::post("/workspace/getDataShortTermTaskModal", "WorkspaceController@getDataShortTermTaskModalAction");



// Personal task board

Route::get("/my-team/workspace/my-tasks", "WorkspaceController@workspacePersonalBoard");

Route::post("/workspace/completeTaskPersonalBoard", "WorkspaceController@completeTaskPersonalBoardAction");

Route::post("/workspace/uncompleteTaskPersonalBoard", "WorkspaceController@uncompleteTaskPersonalBoardAction");

Route::post("/workspace/getPersonalBoardModal", "WorkspaceController@getPersonalBoardModalAction");

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

Route::get("/forum/{slug}/{id}", "ForumController@forumThreadAction");

Route::post("/forum/postThreadComment", "ForumController@postThreadCommentAction");

Route::post("/forum/shareThreadWithTeam", "ForumController@shareThreadWithTeamAction");

Route::post("/forum/addNewThread", "ForumController@addNewThreadAction");

Route::get("/forum/my-following-topics", "ForumController@followedTopicsUserAction");

Route::post("/forum/followMainTopic", "ForumController@followMainTopicAction");

Route::post("/forum/unfollowMainTopic", "ForumController@unfollowMainTopicAction");

Route::get("/forum/activity-timeline", "ForumController@forumActivityTimeline");

Route::post("/forum/getDataForumActivityTimeline", "ForumController@getDataForumActivityTimelineAction");

Route::post("/forum/searchInForum", "ForumController@searchInForumAction");


//=============================MESSAGES============================

Route::post("/message/getTeamChatMessages", "MessageController@teamChatMessagesAction");

Route::post("/message/getTeamGroupChatMessages", "MessageController@teamGroupChatMessagesAction");

Route::post("/message/getUserChatMessages", "MessageController@userChatMessagesAction");

Route::post("/message/getUserChatReceiver", "MessageController@getUserChatReceiver");

Route::post("/message/getSupportTicketMessages", "MessageController@getSupportTicketMessagesAction");

Route::post("/message/getAssistanceTicketMessages", "MessageController@getAssistanceTicketMessagesAction");

Route::post("/message/getTeamProductComments", "MessageController@getTeamProductCommentsAction");

Route::post("/message/getUserWorkComments", "MessageController@getUserWorkCommentsAction");






//=============================PAGES=============================

Route::get("/page/{slug}", "PageController@pagesIndexAction");

Route::get("/what-is-innocreation", "PageController@pagesAboutUsAction");

Route::get("/platform-idea", "PageController@platformIdeaAction");

Route::post("/page/submitCustomerIdea", "PageController@submitCustomerIdeaAction");



//===========================USER/EXPERTISES PAGE=========================

Route::get("/expertises", "UsersExpertisesListController@expertisesListAction");

Route::get("/{title}/users", "UsersExpertisesListController@usersListAction");

Route::post("/userExpertiseList/searchExpertise", "UsersExpertisesListController@searchExpertiseAction");




//==

//=======================ADMIN PANEL==========================

Route::get("/admin/statistics", "AdminController@statisticsAction");

Route::get("/admin/userAccounts", "AdminController@userAccountsListAction");

Route::get("/admin/user/{id}", "AdminController@userEditorAction");

Route::post("/admin/saveUser", "AdminController@saveUserAction");

Route::post("/admin/deleteUser", "AdminController@deleteUserAction");

Route::post("/admin/switchLogin", "AdminController@switchLoginAction");

Route::post("/admin/deleteUserProfilePicture", "AdminController@deleteUserProfilePictureAction");

Route::post("/admin/saveSingleUserExpertise", "AdminController@saveSingleUserExpertiseAction");

Route::get("/admin/teamList", "AdminController@teamListAction");

Route::get("/admin/team/{id}", "AdminController@teamEditorAction");

Route::post("/admin/saveTeam", "AdminController@saveTeamAction");

Route::post("/admin/sendMessageTeamChat", "AdminController@sendMessageTeamChatAction");

Route::post("/admin/saveNeededExpertiseBackend", "AdminController@saveNeededExpertiseBackendAction");

Route::post("/admin/deleteTeamProfilePicture", "AdminController@deleteTeamProfilePictureAction");

Route::get("/admin/support-tickets", "AdminController@supportTicketsIndexAction");

Route::post("/admin/assignHelperToSupportTicket", "AdminController@assignHelperToSupportTicketAction");

Route::post("/admin/changeStatusSupportTicket", "AdminController@changeStatusSupportTicketAction");

Route::get("/admin/messages", "AdminController@messagesIndexAction");

Route::get("/admin/forumMainTopicList", "AdminController@forumMainTopicListAction");

Route::get("/admin/forumMainTopicEditor/{id}", "AdminController@forumMainTopicEditorAction");

Route::get("/admin/forumMainTopicEditor", "AdminController@forumMainTopicEditorAction");

Route::post("/admin/saveForumMainTopic", "AdminController@saveForumMainTopicAction");

Route::post("/admin/publishForumMainTopic", "AdminController@publishForumMainTopicAction");

Route::post("/admin/hideForumMainTopic", "AdminController@hideForumMainTopicAction");

Route::post("/admin/deleteForumMainTopic", "AdminController@deleteForumMainTopicAction");

Route::get("/admin/forumThreadList", "AdminController@forumThreadListAction");

Route::post("/admin/deleteForumThread", "AdminController@deleteForumThreadAction");

Route::post("/admin/closeForumThread", "AdminController@closeForumThreadAction");

Route::post("/admin/openForumThread", "AdminController@openForumThreadAction");

Route::get("/admin/expertiseList", "AdminController@expertiseListAction");

Route::post("/admin/deleteExpertise", "AdminController@deleteExpertiseAction");

Route::get("/admin/faqList", "AdminController@faqListAction");

Route::get("/admin/faqEditor/{id}", "AdminController@faqEditorAction");

Route::get("/admin/faqEditor", "AdminController@faqEditorAction");

Route::post("/admin/saveFaq", "AdminController@saveFaqAction");

Route::post("/admin/publishFaq", "AdminController@publishFaqAction");

Route::post("/admin/hideFaq", "AdminController@hideFaqAction");

Route::post("/admin/deleteFaq", "AdminController@deleteFaqAction");

Route::get("/admin/membershipPackages", "AdminController@membershipPackagesAction");

Route::post("/admin/saveMembershipPackage", "AdminController@saveMembershipPackageAction");

Route::get("/admin/customMembershipPackages", "AdminController@customMembershipPackagesAction");

Route::post("/admin/saveCustomMembershipPackage", "AdminController@saveCustomMembershipPackageAction");

Route::post("/admin/addOptionCustomMembershipPackage", "AdminController@addOptionCustomMembershipPackageAction");

Route::post("/admin/addCategoryCustomMembershipPackage", "AdminController@addCategoryCustomMembershipPackageAction");

Route::get("/admin/pageList", "AdminController@pageListAction");

Route::get("/admin/pageEditor/{id}", "AdminController@pageEditorAction");

Route::get("/admin/pageEditor", "AdminController@pageEditorAction");

Route::post("/admin/savePage", "AdminController@savePageAction");

Route::get("/admin/customerIdeaList", "AdminController@customerIdeaListAction");

Route::post("/admin/changeStatusCustomerIdea", "AdminController@changeStatusCustomerIdeaAction");

Route::get("/admin/serviceReviewList", "AdminController@serviceReviewListAction");

Route::get("/admin/mailMessageList", "AdminController@mailMessageListAction");

Route::post("/admin/getMailMessageModalData", "AdminController@getMailMessageModalDataAction");

Route::post("/admin/getSearchResultsUserChat", "AdminController@getSearchResultsUserChatAction");

// commercial data
Route::get("/admin/commercialData", "AdminCommercialDataController@commercialDataIndexAction");

Route::post("/commercialData/exportDataCsv", "AdminCommercialDataController@exportDataCsvAction");

//mass message
Route::get("/admin/mass-message", "AdminMassMessageController@massMessageIndexAction");

Route::get("/admin/mailTemplateList", "AdminTemplateController@mailTemplateListAction");

Route::get("/admin/mailTemplateEditor/{id}", "AdminTemplateController@mailTemplateEditorAction");

Route::get("/admin/mailTemplateEditor", "AdminTemplateController@mailTemplateEditorAction");

Route::post("/admin/saveMailTemplate", "AdminTemplateController@saveMailTemplateAction");

Route::post("/admin/sendMassEmail", "AdminMassMessageController@sendMassEmailAction");


Route::post("/admin/sendUserMessage", "AdminController@sendUserMessageAction");

//expertises

Route::get("/admin/expertise/{id}", "AdminController@expertiseEditorAction");

Route::post("/admin/saveExpertise", "AdminController@saveExpertiseAction");

Route::post("/admin/editExpertiseImage", "AdminController@editExpertiseImageAction");

Route::post("/admin/randomImagesExpertises", "AdminController@randomImagesExpertisesAction");

Route::post("/admin/randomImagesExpertiseLinktables", "AdminController@randomImagesExpertiseLinktablesAction");

//feed posts
Route::get("/admin/innocreatives-posts", "AdminFeedPostsController@indexAction");

Route::post("/adminFeedPosts/approvePost", "AdminFeedPostsController@approvePostAction");

Route::post("/adminFeedPosts/declinePost", "AdminFeedPostsController@declinePostAction");






//=======================FEED=============================
Route::get("/team-products", "FeedController@TeamProductsAction");

Route::post("/feed/likeTeamProduct", "FeedController@likeTeamProductAction");

Route::post("/feed/getSearchedUsersTeamProduct", "FeedController@getSearchedUsersTeamProductAction");

Route::post("/feed/shareFeedPost", "FeedController@shareFeedPostAction");

Route::post("/feed/postTeamProductComment", "FeedController@postTeamProductCommentAction");

Route::get("/team-product/{slug?}", "FeedController@TeamProductsAction");

//=======================WORKFEED=============================
Route::get("/innocreatives", "FeedController@workFeedIndexAction");

Route::post("/feed/getUserworkPosts", "FeedController@getUserworkPostsAction");

Route::post("/feed/getMoreUserworkPosts", "FeedController@getMoreUserworkPostsAction");

Route::get("/innocreatives/{id?}", "FeedController@workFeedIndexAction");

Route::post("/feed/requestPostUserWork", "FeedController@requestPostUserWorkAction");

Route::post("/feed/postUserWorkComment", "FeedController@postUserWorkCommentAction");

Route::post("/feed/deleteUserWorkPost", "FeedController@deleteUserWorkPostAction");

Route::post("/feed/editUserWorkPost", "FeedController@editUserWorkPostAction");

Route::post("/getUserWorkPostModal", "FeedController@getUserWorkPostModal");

Route::post("/openInterestsModal", "FeedController@openInterestsModal");

Route::post("/feed/unhashId", "FeedController@unhashId");

Route::post("/feed/interestPost", "FeedController@interestPostAction");

Route::post("/feed/disInterestPost", "FeedController@disInterestPostAction");

//========================CHECKOUT/PACKAGES========================

Route::get("/pricing", "CheckoutController@pricingAction");

Route::get("/becoming-a-{title?}", "CheckoutController@selectPackageAction");

Route::get("/create-custom-package", "CheckoutController@selectPackageAction");

Route::post("/checkout/saveUserFromCheckout", "CheckoutController@saveUserFromCheckoutAction");

Route::post("/checkout/packagePricePreference", "CheckoutController@packagePricePreferenceAction");

Route::post("/checkout/setSplitTheBillData", "CheckoutController@setSplitTheBillDataAction");

Route::post("/checkout/savePaymentInfo", "CheckoutController@savePaymentInfoAction");

Route::post("/checkout/setDataCustomPackage", "CheckoutController@setDataCustomPackageAction");

Route::post("/checkout/authorisePaymentRequest", "CheckoutController@authorisePaymentRequestAction");

Route::post("/checkout/getFunctionsModal", "CheckoutController@getFunctionsModalAction");

Route::get("/thank-you", "CheckoutController@donePaymentAction");

Route::get("/almost-there", "CheckoutController@splitTheBillNotification");

Route::post("/webhook/mollieRecurring", "ApiController@webhookMollieAction");

Route::post("/webhook/mollieRecurringPayment", "ApiController@webhookMolliePaymentAction");

Route::post("/checkout/getChangePackageModal", "CheckoutController@getChangePackageModalAction");

Route::post("/user/sendChangePackageRequest", "UserController@sendChangePackageRequestAction");

Route::post("/checkout/changePackage", "CheckoutController@changePackageAction");

//========================INVOICES========================

Route::post("/invoice/{hash}", "InvoiceController@generateMonthlyInvoiceAction");

//========================COLLABORATION CHAT========================

Route::get("/collaborate", "CollaborateController@indexAction");

Route::post("/collaborate/sendMessage", "CollaborateController@sendMessageAction");

//========================ALEXA========================
Route::post("/alexa", "AlexaController@alexaEndpoint");


//========================REGISTER PROCESS========================

Route::post("/create-my-account", "RegisterProcessController@indexAction");

Route::get("/create-my-account", "RegisterProcessController@indexAction");

Route::post("/registerProcess/saveUserCredentials", "RegisterProcessController@saveUserCredentialsAction");

Route::post("/registerProcess/saveUserResidence", "RegisterProcessController@saveUserResidenceAction");

Route::post("/registerProcess/saveUserExpertises", "RegisterProcessController@saveUserExpertisesAction");

Route::post("/registerProcess/saveUserTexts", "RegisterProcessController@saveUserTextsAction");

//========================Team Projects========================

Route::get("/my-team/projects", "TeamProjectController@indexAction");

Route::get("/my-team/project/{slug}", "TeamProjectController@teamProjectPlannerAction");

Route::post("/teamProject/getFoldersAndTasks", "TeamProjectController@getFoldersAndTasksProject");

Route::post("/teamProject/getTaskData", "TeamProjectController@getTaskData");

Route::post("/teamProject/openRecentTask", "TeamProjectController@openRecentTask");

Route::post("/teamProject/setRecentTask", "TeamProjectController@setRecentTask");

Route::post("/teamProject/updateTaskContent", "TeamProjectController@updateTaskContent");

Route::post("/teamProject/assignUserToTask", "TeamProjectController@assignUserToTask");

Route::post("/teamProject/editLabelsTask", "TeamProjectController@editLabelsTask");

Route::post("/teamProject/addDueDate", "TeamProjectController@addDueDate");

Route::post("/teamProject/addFolderToProject", "TeamProjectController@addFolderToProject");

Route::post("/teamProject/getTasksOfFolder", "TeamProjectController@getTasksOfFolder");

Route::post("/teamProject/addTask", "TeamProjectController@addTask");


//==

