<?php

namespace App\Http\Controllers;

use App\ConnectRequestLinktable;
use App\CustomTeamPackage;
use App\Emoji;
use App\Expertises;
use App\Expertises_linktable;
use App\Favorite_expertises_linktable;
use App\FavoriteTeamLinktable;
use App\InviteRequestLinktable;
use App\Invoice;
use App\JoinRequestLinktable;
use App\MembershipPackage;
use App\Page;
use App\ServiceReview;
use App\Services\UserAccount\UserAccountPortfolioService;
use App\SplitTheBillLinktable;
use App\SupportTicket;
use App\SupportTicketMessage;
use App\Team;
use App\TeamCreateRequest;
use App\TeamReview;
use App\User;
use App\UserChat;
use App\UserFollowLinktable;
use App\UserMessage;
use App\Payments;
use App\UserPortfolio;
use App\TeamPackage;
use App\NeededExpertiseLinktable;
use App\UserWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Middleware\RolesMiddleware;
use App\Services\FeedServices\SwitchUserWork as SwitchUserWork;
use App\Services\AppServices\MailgunService as Mailgun;
use App\Services\AppServices\UnsplashService as Unsplash;
use App\Services\UserAccount\UserExpertises as UserExpertises;
use App\Services\UserAccount\UserPrivacySettingsService as UserPrivacySettings;
use App\Services\UserAccount\EditProfileImage as EditProfileImage;
use App\Services\UserAccount\UserAccountPortfolioService as UserPortfolioService;


use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccount(SwitchUserWork $switch){
        if($this->authorized()) {
            if (Session::has("user_name")) {
                $user = User::select("*")->where("id", Session::get("user_id"))->first();
                if($user->country_id == null){
                    return redirect("/create-my-account");
                } else if($user->country_id != null && $user->getExpertises(true) == ""){
                    return redirect("/create-my-account");
                }
                $id = Session::get("user_id");
                $user = User::select("*")->where("id", $id)->first();

                $connections = $switch->listConnections($id);
                return view("/public/user/userAccount", compact("user", "connections"));
            } else {
                return view("/public/home/home");
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserAccount(Request $request){
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $user->skype = $request->input("skype");
        $user->motivation = $request->input("motivation_user");
        $user->introduction = $request->input("introduction_user");
        if($request->input("notifications") == "on"){
            $user->notifications = 1;
        } else {
            $user->notifications = 0;
        }
        $user->save();
        return redirect("/my-account/privacy-settings");
    }

    public function editBannerImageAction(Request $request, EditProfileImage $editProfileImage){
        return $editProfileImage->editBannerImage($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userAccountExpertises(){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $expertises_linktable = expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
            $expertises = Expertises::select("*")->get();
            return view("/public/user/userAccountExpertises", compact("expertises_linktable", "user_id", "expertises"));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveUserExpertiseDescription(Request $request)
    {
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $description = $request->input("userExpertiseDescription");

        $expertises = expertises_linktable::select("*")->where("user_id", $user_id)->where("expertise_id", $expertise_id)->first();
        $expertises->description = $description;
        $expertises->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteUserExpertiseAction(Request $request){
        $expertise_id = $request->input("expertise_id");
        $expertise_linktable = Expertises_linktable::select("*")->where("id", $expertise_id)->first();
        $expertise_linktable->delete();
        return 1;
    }

    public function addUserExpertiseAction(Request $request, Unsplash $unsplash){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise");
        $experience = $request->input("expertise_description");
        $newExpertise = ucfirst($request->input("newExpertises"));



        if(!$newExpertise) {
            $expertise_linktable = new expertises_linktable();
            $expertise_linktable->user_id = $user_id;
            $expertise_linktable->expertise_id = $expertise_id;
            $expertise_linktable->description = $experience;
            $expertise_linktable->save();

            $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise_linktable->expertises->First()->title));
            $expertise_linktable->image = $imageObject->image;
            $expertise_linktable->photographer_name = $imageObject->photographer->name;
            $expertise_linktable->photographer_link = $imageObject->photographer->url;
            $expertise_linktable->image_link = $imageObject->image_link;
            $expertise_linktable->save();
        } else {
            $existingExpertise = Expertises::select("*")->where("title", $newExpertise)->first();
            if(count($existingExpertise) > 0){
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("This expertise already seems to exist");
            } else {
                $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($newExpertise));
                $expertise = new Expertises();
                $expertise->title = $newExpertise;
                $expertise->image = $imageObject->image;
                $expertise->photographer_name = $imageObject->photographer->name;
                $expertise->photographer_link = $imageObject->photographer->url;
                $expertise->image_link = $imageObject->image_link;
                $expertise->slug = str_replace(" ", "-", strtolower($newExpertise));
                $expertise->save();

                $expertise_linktable = new expertises_linktable();
                $expertise_linktable->user_id = $user_id;
                $expertise_linktable->expertise_id = $expertise->id;
                $expertise_linktable->description = $experience;
                $expertise_linktable->save();

                $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise_linktable->expertises->First()->title));
                $expertise_linktable->image = $imageObject->image;
                $expertise_linktable->photographer_name = $imageObject->photographer->name;
                $expertise_linktable->photographer_link = $imageObject->photographer->url;
                $expertise_linktable->image_link = $imageObject->image_link;
                $expertise_linktable->save();
                return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Succesfully added $newExpertise as your expertise!");
            }
        }
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function getEditUserExpertiseModalAction(Request $request, UserExpertises $userExpertises, Unsplash $unsplash){
        return $userExpertises->getEditUserExpertiseModalImage($request, $unsplash);
    }

    public function editUserExpertiseImage(Request $request, UserExpertises $userExpertises, Unsplash $unsplash){
        $userExpertises->editUserExpertiseImage($request, $unsplash);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamBenefits()
    {
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            return view("/public/user/teamBenefits", compact("user"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNewTeam(Request $request) {
        $team_name = $request->input("team_name");
        $user_id = $request->input("user_id");
        $all_teams = Team::select("*")->where("team_name", $team_name)->get();
        $user = User::select("*")->where("id", $user_id)->first();
        if(count($all_teams) != 0){
            $error = "This name already exists";
            return redirect("/my-account/teamInfo")->withErrors("This name already exists");
        } else {
            $team = new Team;
            $team->team_name = ucfirst($team_name);
            $team->slug = str_replace(" ", "-", strtolower($team_name));
            $team->ceo_user_id = $user_id;
            $team->created_at = date("Y-m-d H:i:s");
            $team->team_profile_picture = "defaultProfilePicture.png";
            $team->save();

            $user->team_id = $team->id;
            $user->save();

            $teamCreateRequests = TeamCreateRequest::select("*")->where("receiver_user_id", $user_id)->where("accepted", 0)->get();
            if(count($teamCreateRequests)){
                foreach($teamCreateRequests as $teamCreateRequest){
                    $teamCreateRequest->accepted = 2;
                    $teamCreateRequest->save();
                }
            }

            Session::set("team_id", $team->id);
            Session::set("team_name", $team->team_name);


            return redirect("/my-team");
        }
    }

    public function favoriteExpertisesUser(){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            $expertises = Expertises::select("*")->inRandomOrder()->limit("6")->get();
            $favoriteExpertisesUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
            return view("/public/user/favoriteExpertisesUser", compact("expertises", "user", "favoriteExpertisesUser"));
        }
    }

    public function saveFavoriteExperisesUser(Request $request, UserExpertises $userExpertisesService){
        return $userExpertisesService->saveFavoriteExperisesUser($request);
    }

    public function deleteFavoriteExpertisesUser(Request $request, UserExpertises $userExpertisesService){
        return $userExpertisesService->deleteFavoriteExpertisesUser($request);
    }

    public function saveUserProfilePictureAction(Request $request){
        $user_id = $request->input("user_id");
        $file = $request->file("profile_picture");
        $size = $this->formatBytes($file->getSize());
        if($size < 8) {
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());

            $user = User::select("*")->where("id", $user_id)->first();
            $exists = Storage::disk('spaces')->exists("users/" . $user->slug . "/profilepicture/" . $filename);
            if (!$exists) {
                Storage::disk('spaces')->delete("users/" . $user->slug . "/profilepicture/" . $user->profile_picture);
                $image = $request->file('profile_picture');
                Storage::disk('spaces')->put("users/" . $user->slug . "/profilepicture/" . $filename, file_get_contents($image->getRealPath()), "public");
            }
            $user->profile_picture = $filename;
            $user->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect("/account")->withErrors("Image is too large. The max upload size is 8MB");
        }
    }

    public function userAccountPortfolio(){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            $userPortfolios = UserPortfolio::select("*")->where("user_id", $user_id)->get();
            $amountPortfolios = count($userPortfolios);
            return view("/public/user/portfolio/userAccountPortfolio", compact("userPortfolios", "amountPortfolios", "user"));
        }
    }

    public function addUserAccountPortfolio(Request $request, UserPortfolioService $userPortfolioService){
        return $userPortfolioService->saveNewPortfolio($request);
    }

    public function userPortfolioDetail($slug, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->portfolioDetailPage($slug);
    }

    public function addImagesPortfolio(Request $request, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->addImagesPortfolio($request);
    }

    public function editTitlePortfolioImage(Request $request, UserAccountPortfolioService $userPortfolioService){
        $userPortfolioService->editTitleImage($request);
    }

    public function editDescPortfolioImage(Request $request, UserAccountPortfolioService $userPortfolioService){
        $userPortfolioService->editDescImage($request);
    }

    public function removePortfolioImage(Request $request, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->removeImage($request);
    }

    public function addImageToAudio(Request $request, UserAccountPortfolioService $userPortfolioService){
        return $userPortfolioService->addImageToAudio($request);
    }

    public function editUserPortfolio(Request $request){
        $portfolio_id = $request->input("portfolio_id");
        $file = $request->file("portfolio_image");
        $title = $request->input("portfolio_title");
        $description = $request->input("description_portfolio");
        $link = $request->input("portfolio_link");

        $userPortfolio = UserPortfolio::select("*")->where("id",$portfolio_id)->first();
        $userPortfolio->title = $title;
        $userPortfolio->description = $description;
        if($link != null){
            $userPortfolio->link = $link;
        }
        $userSlug = $userPortfolio->user->slug;
        if($file != null) {
            $size = $this->formatBytes($file->getSize());
            if ($size < 8) {
                $filename = strtolower(str_replace(" ", "-", $userPortfolio->title)) . "." . $file->getClientOriginalExtension();
                $exists = Storage::disk('spaces')->exists("users/" . $userSlug . "/portfolios/" . $filename);
                if ($exists) {
                    Storage::disk('spaces')->delete("users/" . $userSlug . "/portfolios/" . $filename);
                }
                Storage::disk('spaces')->put("users/$userSlug/portfolios/" . $filename, file_get_contents($file->getRealPath()), "public");
                $userPortfolio->image = $filename;
                $userPortfolio->save();
                return redirect($_SERVER["HTTP_REFERER"]);
            } else {
                return redirect("/account")->withErrors("Image is too large. The max upload size is 8MB");
            }
        }
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteUserPortfolio(Request $request){
        $portfolio_id = $request->input("portfolio_id");
        $userPortfolio = UserPortfolio::select("*")->where("id", $portfolio_id)->first();
        $exists = Storage::disk('spaces')->exists("users/" . $userPortfolio->user->slug . "/portfolios/" . $userPortfolio->image);
        if($exists) {
            Storage::disk('spaces')->delete("users/" . $userPortfolio->user->slug . "/portfolios/" . $userPortfolio->image);
        }
        $userPortfolio->delete();
        return 1;
    }

    public function userAccountChats(Request $request){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            if (request()->has('user_id')) {
                $urlParameter = request()->user_id;
            }
            if (request()->has('user_chat_id')) {
                $urlParameterChat = request()->user_chat_id;
                Session::set("userChatId", $urlParameterChat);
            }
            $innocreationChat = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", 1)->first();
            $userChats = UserChat::select("*")->where("creator_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->get();
            $user = User::select("*")->where("id", $user_id)->first();
            $streamToken = $user->stream_token;
            $emojis = Emoji::select("*")->get();
            if (count($userChats) != 0) {
                return view("/public/user/userAccountChats", compact("userChats", "user_id", "urlParameter", "urlParameterChat", "innocreationChat", "streamToken", "emojis"));
            }
            return view("/public/user/userAccountChats", compact("user_id", "inn", "streamToken", "emojis"));
        }
    }

    public function deleteUserChatAction(Request $request){
        $userChatId = $request->input("user_chat_id");

        $userMessages = UserMessage::select("*")->where("user_chat_id", $userChatId)->get();
        if(count($userMessages) > 0) {
            foreach ($userMessages as $userMessage) {
                $userMessage->delete();
            }
        }
        $userChat = UserChat::select("*")->where("id", $userChatId)->first();
        $userChat->delete();
    }

    public function searchChatUsers(Request $request){
        if($this->authorized()) {
            // gets all the users where user searched on to chat with

            $user_id = Session::get("user_id");
            $searchInput = $request->input("searchChatUsers");
            $emojis = Emoji::select("*")->get();

            $userChats = UserChat::select("*")->where("creator_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->get();
            if (strlen($searchInput) > 0) {
                $idArray = [];
                foreach ($userChats as $userChat) {
                    if($userChat->creator_user_id == $user_id){
                        $name = $userChat->receiver->getName();
                    } else if($userChat->creator_user_id == 1) {
                        $name = "Innocreation";
                    } else {
                        $name = $userChat->creator->getName();
                    }
                    if (strpos($name, ucfirst($searchInput)) !== false) {
                        array_push($idArray, $userChat->id);
                    }
                }
                $searchedUserChats = UserChat::select("*")->whereIn("id", $idArray)->get();
            } else {
                $searchInput = false;
            }
            $user = User::select("*")->where("id", $user_id)->first();
            $streamToken = $user->stream_token;
            if(strlen($searchInput) < 1){
                return redirect("/my-account/chats");
            }
            return view("/public/user/userAccountChats", compact("searchedUserChats", "user_id", "streamToken", "emojis"));
        }
    }

    public function selectChatUser(Request $request){
        if($this->authorized()) {
            // selects the user. The user wants to chat with and adds it to the database

            $receiver_user_id = $request->input("receiver_user_id");
            $creator_user_id = $request->input("creator_user_id");

            $existingUserChat = UserChat::select("*")->where("receiver_user_id", $receiver_user_id)->where("creator_user_id", $creator_user_id)->orWhere("receiver_user_id", $creator_user_id)->where("creator_user_id", $receiver_user_id)->get();
            if (count($existingUserChat) == 0) {
                $userChat = new UserChat();
                $userChat->creator_user_id = $creator_user_id;
                $userChat->receiver_user_id = $receiver_user_id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();
                return redirect("/my-account/chats?user_chat_id=$userChat->id");
            }
            $id = $existingUserChat->First()->id;
            return redirect("/my-account/chats?user_chat_id=$id");

        }
    }

    public function sendMessageUserAction(Request $request){
        if($this->authorized()) {
            // sends a message to the user. The user selected. with the sended time and return to the page with id.
            // so the collapse stays open from the user you are chatting with

            $user_chat_id = $request->input("user_chat_id");
            $sender_user_id = $request->input("sender_user_id");
            $message = $request->input("message");

            $messageArray = ["message" => $message, "timeSent" => $this->getTimeSent()];
            echo json_encode($messageArray);

            $userChat = UserChat::select("*")->where("id", $user_chat_id)->first();

            if(strlen($message) > 0 && $message != "") {
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = $sender_user_id;
                $userMessage->user_chat_id = $user_chat_id;
                $userMessage->time_sent = $this->getTimeSent();
                $userMessage->message = $request->input("message");
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();


                if ($userChat->receiver_user_id == $sender_user_id) {
                    $receiverId = $userChat->creator_user_id;
                } else {
                    $receiverId = $userChat->receiver_user_id;
                }

                $client = $this->getService("stream");
                $messageFeed = $client->feed('user', $receiverId);
                $timeSent = $this->getTimeSent();

                // Add the activity to the feed
                $data = ["actor" => "$receiverId", "receiver" => "$sender_user_id", "userChat" => "$user_chat_id", "message" => "$message", "timeSent" => "$timeSent", "verb" => "userMessage", "object" => "3",];
                $messageFeed->addActivity($data);

                if ($receiverId != 1) {
                    $user = User::select("*")->where("id", $receiverId)->first();

                    $this->saveAndSendEmail($user, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));
                }

            }
        }
    }

    public function favoriteTeamAction(Request $request){
        if($this->authorized()) {
            // adds and deletes team to user favorites
            $team_id = $request->input("team_id");
            $user_id = Session::get("user_id");
            $favoriteExists = FavoriteTeamLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->first();
            if (count($favoriteExists) == 0) {
                $favoriteTeam = new FavoriteTeamLinktable();
                $favoriteTeam->team_id = $team_id;
                $favoriteTeam->user_id = $user_id;
                $favoriteTeam->save();
                return 1;
            } else {
                $favoriteExists->delete();
                return 2;
            }
        }
    }

    public function applyForTeamAction(Request $request){
        if($this->authorized()) {
            // sends a join request to the team.
            // users applies for the team.
            $team_id = $request->input("team_id");
            $user_id = $request->input("user_id");
            $expertise_id = $request->input("expertise_id");

            $checkJoinRequests = JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
            if (count($checkJoinRequests) == 0) {
                $team = Team::select("*")->where("id", $team_id)->first();

                $joinRequest = new JoinRequestLinktable();
                $joinRequest->team_id = $team_id;
                $joinRequest->user_id = $user_id;
                $joinRequest->expertise_id = $expertise_id;
                $joinRequest->accepted = 0;
                $joinRequest->created_at = date("Y-m-d");
                $joinRequest->save();

                $ceoFirstname = $team->users->firstname;

                $existingUserChat = UserChat::select("*")->where("creator_user_id", $user_id)->where("receiver_user_id",  $joinRequest->team->ceo_user_id)->orWhere("creator_user_id",  $joinRequest->team->ceo_user_id)->where("receiver_user_id", $user_id)->first();
                if(count($existingUserChat) < 1){
                    $userChat = new UserChat();
                    $userChat->creator_user_id = $user_id;
                    $userChat->receiver_user_id = $joinRequest->team->ceo_user_id;
                    $userChat->created_at = date("Y-m-d H:i:s");
                    $userChat->save();

                    $userChatId = $userChat->id;
                } else {
                    $userChatId = $existingUserChat->id;
                }
                $message = new UserMessage();
                $message->sender_user_id = $user_id;
                $message->user_chat_id = $userChatId;
                $message->message = "Hey $ceoFirstname I have done a request to join your team!";
                $message->time_sent = $this->getTimeSent();
                $message->created_at = date("Y-m-d H:i:s");
                $message->save();

                $user = User::select("*")->where("id", $user_id)->first();
                $this->saveAndSendEmail($joinRequest->team->users, "Team join request from $user->firstname!", view("/templates/sendJoinRequestToTeam", compact("user", "team")));

                if($request->input("register")){
                    return redirect("/my-account/team-join-requests");
                } else {
                    return redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                if($request->input("register")){
                    return redirect("/account")->withErrors("You already applied for this team");
                } else {
                    return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already applied for this team");
                }
            }
        }
    }

    public function userTeamJoinRequestsAction(){
        if($this->authorized()) {
            // gets all the join requests for the user
            $user_id = Session::get("user_id");
            $teamJoinRequests = JoinRequestLinktable::select("*")->where("user_id", $user_id)->get();
            $invites = InviteRequestLinktable::select("*")->where("user_id", $user_id)->get();
            return view("/public/user/userTeamJoinRequests", compact("teamJoinRequests", "invites", "user_id"));
        }
    }

    public function postTeamReviewAction(Request $request){
        if($this->authorized()) {
            // posts team review for team
            // calculates the support points the team gets for the review.
            $team_id = $request->input("team_id");
            $user_id = $request->input("user_id");
            $stars_value = $request->input("star_value");

            $reviewMessage = $request->input("review");
            $title = $request->input("review_title");

            $reviews = TeamReview::select("*")->where("team_id", $team_id)->where("writer_user_id", $user_id)->get();
            $team = Team::select("*")->where("id", $team_id)->first();
            if (count($reviews) == 0 && $user_id != $team->ceo_user_id) {

                $review = new TeamReview();
                $review->team_id = $team_id;
                $review->writer_user_id = $user_id;
                $review->title = $title;
                $review->review = $reviewMessage;
                $review->stars = $stars_value;
                $review->created_at = date("Y-m-d H:i:s");
                $review->save();


                $user = User::select("*")->where("id", $user_id)->first();
                $team->support = $team->calculateSupport($stars_value, $team_id);
                $team->save();

                $message = new UserMessage();
                $message->sender_user_id = $team->ceo_user_id;
                $message->team_id = $team_id;
                $message->message = "$user->firstname has written a new review for this team! go check it out!";
                $message->time_sent = $this->getTimeSent();
                $message->created_at = date("Y-m-d H:i:s");
                $message->save();


                foreach($team->getMembers() as $member) {
                    $this->saveAndSendEmail($member, "New review from $user->firstname!", view("/templates/sendTeamReviewMail", compact("user", "team", "member")));
                }
                return redirect($_SERVER["HTTP_REFERER"]);
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already wrote a review or you are the CEO of this team");
            }
        }
    }

    public function acceptTeamInviteAction(Request $request){
        if($this->authorized()) {
            // user accepts the team invite
            // Sends a message to the team.
            // Rejects any other invite sent to the user
            $user_id = $request->input("user_id");
            $invite_id = $request->input("invite_id");
            $expertise_id = $request->input("expertise_id");
            $team_id = $request->input("team_id");
            $invite = InviteRequestLinktable::select("*")->where("id", $invite_id)->first();
            $invite->accepted = 1;
            $invite->save();

            $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
            $neededExpertise->amount = $neededExpertise->amount - 1;
            $neededExpertise->save();

            $otherInvites = InviteRequestLinktable::select("*")->where("user_id", $user_id)->where("accepted", 0)->get();
            if (count($otherInvites) > 0) {
                foreach ($otherInvites as $otherInvite) {
                    $otherInvite->accepted = 2;
                    $otherInvite->save();
                }
            }

            $teamCreateRequests = TeamCreateRequest::select("*")->where("receiver_user_id", $user_id)->where("accepted", 0)->get();
            if(count($teamCreateRequests)){
                foreach($teamCreateRequests as $teamCreateRequest){
                    $teamCreateRequest->accepted = 2;
                    $teamCreateRequest->save();
                }
            }

            $teamName = $invite->teams->First()->team_name;

            $user = User::select("*")->where("id", $invite->users->First()->id)->first();
            $user->team_id = $invite->team_id;
            $user->save();
            Session::set('team_id', $user->team_id);
            Session::set('team_name', $user->team->team_name);


            $message = new UserMessage();
            $message->sender_user_id = $user->id;
            $message->team_id = $team_id;
            $message->message = "Hey $teamName i am happy to say, that i accepted your invite to join this team.";
            $message->time_sent = $this->getTimeSent();
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $team = Team::select("*")->where("id", $team_id)->first();

            $this->saveAndSendEmail($team->users,  "Accepted invitation!", view("/templates/sendInviteAcceptionTeam", compact("user", "team")));

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function rejectTeamInviteAction(Request $request){
        if($this->authorized()) {
            //rejects the team invite sent to the user + sends a message to the CEO of the team.
            $invite_id = $request->input("invite_id");
            $invite = InviteRequestLinktable::select("*")->where("id", $invite_id)->first();
            $invite->accepted = 2;
            $invite->save();

            $ceo = User::select("*")->where("id", $invite->team->First()->ceo_user_id)->First();
            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));

            $message = new UserMessage();
            $message->sender_user_id = $invite->users->first()->id;
            $message->receiver_user_id = $invite->teams->first()->ceo_user_id;
            $message->message = "Hey $ceo I decided to reject your invite";
            $message->time_sent = $time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $message = new UserMessage();
            $message->sender_user_id = $invite->teams->first()->ceo_user_id;
            $message->receiver_user_id = $invite->users->first()->id;
            $message->message = null;
            $message->time_sent = null;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function userSupportTickets(){
        if($this->authorized()) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $supportTickets = SupportTicket::select("*")->where("user_id", $user->id)->get();
            return view("/public/user/userSupportTickets", compact("user", "supportTickets"));
        }
    }

    public function sendSupportTicketMessageAction(Request $request){
        if($this->authorized()) {
            $ticket_id = $request->input("ticket_id");
            $sender_user_id = $request->input("sender_user_id");
            $message = $request->input("message");


            if (strlen($message) > 0) {
                $time = $this->getTimeSent();
                $supportTicketMessage = new SupportTicketMessage();
                $supportTicketMessage->support_ticket_id = $ticket_id;
                $supportTicketMessage->sender_user_id = $sender_user_id;
                $supportTicketMessage->message = $message;
                $supportTicketMessage->time_sent = $time;
                $supportTicketMessage->created_at = date("Y-m-d H:i:s");
                $supportTicketMessage->save();

                $messageArray = ["message" => $message, "timeSent" => $time];

                echo json_encode($messageArray);
            }
        }
    }

    public function rateSupportTicketAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $ticketId = $request->input("ticket_id");
            $review = $request->input("review");
            $reviewDescription = $request->input("reviewDetails");
            $rating = $request->input("rating");

            $serviceReview = new ServiceReview();
            $serviceReview->user_id = $userId;
            $serviceReview->ticket_id = $ticketId;
            $serviceReview->review = $review;
            $serviceReview->review_description = $reviewDescription;
            $serviceReview->rating = $rating;
            $serviceReview->service_review_type_id = 1;
            $serviceReview->created_at = date("Y-m-d H:i:s");
            $serviceReview->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thank your for your rating!");
        }
    }

    public function addSupportTicketAction(Request $request){
        if($this->authorized()) {
            $user_id = $request->input("user_id");
            $title = $request->input("supportTicketTitle");
            $question = $request->input("supportTicketQuestion");

            $supportTicket = new SupportTicket();
            $supportTicket->user_id = $user_id;
            $supportTicket->support_ticket_status_id = 2;
            $supportTicket->title = $title;
            $supportTicket->created_at = date("Y-m-d H:i:s");
            $supportTicket->save();

            $supportTicketMessage = new SupportTicketMessage();
            $supportTicketMessage->support_ticket_id = $supportTicket->id;
            $supportTicketMessage->sender_user_id = $user_id;
            $supportTicketMessage->message = $question;
            $supportTicketMessage->time_sent = $this->getTimeSent();
            $supportTicketMessage->created_at = date("Y-m-d H:i:s");
            $supportTicketMessage->save();

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function favoriteTeamsAction(){
        if($this->authorized()) {
            $userId = Session::get("user_id");
            $favoriteTeams = FavoriteTeamLinktable::select("*")->where("user_id", $userId)->get();

            return view("/public/user/favoriteTeams", compact("favoriteTeams"));
        }
    }

    public function paymentDetailsAction(){
        if($this->authorized()) {
            $userId = Session::get("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            $splitTheBillDetails = SplitTheBillLinktable::select("*")->where("user_id", $userId)->get();
            $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

            return view("/public/user/userPaymentDetails", compact("splitTheBillDetails", "teamPackage", "user"));
        }
    }

    public function validateSplitTheBillAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $termsPayment = $request->input("paymentTermsCheck");
            $termsPrivacy = $request->input("privacyTermsCheck");

            $referenceObject = Payments::select("*")->orderBy("id", "DESC")->first();
            $reference = $referenceObject->reference + 1;

            if($termsPayment == 1 && $termsPrivacy == 1){
                $user = User::select("*")->where("id", $userId)->first();
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
                $splitTheBillLinktable->accepted = 1;
                $splitTheBillLinktable->save();

                if($user->getMostRecentPayment()){
                    $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                    if ($teamPackage->custom_team_package_id == null) {
                        $description = $teamPackage->title . " for team " . $teamPackage->team->team_name . "2";
                    } else {
                        $description =  " custom package for team " . $teamPackage->team->team_name . "2";
                    }

                    if($teamPackage->payment_preference == "monthly"){
                        $range = "1 months";
                    } else {
                        $range = "12 months";
                    }

                    // no active subscriptions
                    $mollie = $this->getService("mollie");
                    $customer = $mollie->customers->get($user->mollie_customer_id);
                    $mandates = $customer->mandates();
                    if($mandates[0]->status == "valid" || !$user->hasValidSubscription()) {
                        $customer = $mollie->customers->get($user->mollie_customer_id);
                        $customer->createSubscription([
                            "amount" => [
                                "currency" => "EUR",
                                "value" => number_format($splitTheBillLinktable->amount, 2, ".", "."),
                            ],
                            "interval" => "$range",
                            "description" => $description . $reference . "recurring",
                            "webhookUrl" => $this->getWebhookUrl(true),
                        ]);

                    }
                    $subscriptions = $customer->subscriptions();

                    $paymentTable = new Payments();
                    $paymentTable->user_id = $user->id;
                    $paymentTable->team_id = $user->team_id;
                    $paymentTable->payment_url = null;
                    $paymentTable->payment_method = "creditcard";
                    $paymentTable->amount = $user->getMostRecentPayment()->amount;
                    $paymentTable->reference = $reference;
                    $paymentTable->payment_status = "paid";
                    $paymentTable->sub_id = $subscriptions[0]->id;
                    $paymentTable->created_at = date("Y-m-d H:i:s");
                    $paymentTable->save();
                } else {
                    $user = User::select("*")->where("id", $userId)->first();
                    $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
                    $splitTheBillLinktable->accepted = 1;
                    $splitTheBillLinktable->save();


                    $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                    $fullDomain = $_SERVER['HTTP_HOST'];
                    $domainExplode = explode(".", $fullDomain);
                    if($domainExplode[0] == "secret") {
                        $redirectUrl = "http://secret.innocreation.net/my-account/payment-details";
                    } else {
                        $redirectUrl = "http://innocreation.net/my-account/payment-details";
                    }
                    if ($teamPackage->custom_team_package_id == null) {
                        $description = $teamPackage->title . " for team " . $user->team->team_name;
                    } else {
                        $description =  " custom package for team " . $user->team->team_name;
                    }

                    $price = number_format($splitTheBillLinktable->amount, 2, ".", ".");
                    $payment = Payments::select("*")->orderBy("id", "DESC")->first();
                    $reference = $payment->reference + 1;

                    $mollie = $this->getService("mollie");
                    $paymentMollie = $mollie->payments->create([
                        "amount" => [
                            "currency" => "EUR",
                            "value" => $price
                        ],
                        "description" => $description,
                        "redirectUrl" => $redirectUrl,
                        "webhookUrl" => $this->getWebhookUrl(),
                        "method" => "creditcard",
                        "sequenceType" => "first",
                        "customerId" => "$user->mollie_customer_id",
                        "metadata" => [
                            "referenceAndUserId" => $reference . "-" . $user->id,
                        ],
                    ]);

                    if($paymentMollie->status == "open") {
                        $payment = new Payments();
                        $payment->user_id = $user->id;
                        $payment->team_id = $user->team_id;
                        $payment->payment_id = $paymentMollie->id;
                        $payment->payment_url = $paymentMollie->_links->checkout->href;
                        $payment->payment_method = $paymentMollie->method;
                        $payment->amount = $price;
                        $payment->reference = $reference;
                        $payment->payment_status = "Open";
                        $payment->created_at = date("Y-m-d H:i:s");
                        $payment->save();
                    }
                    return redirect($payment->payment_url);
                }
                return redirect($_SERVER["HTTP_REFERER"]);

            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("Agree with the Term to continue");
            }
        }
    }


    public function validateChangeAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $user = User::select("*")->where("id", $userId)->first();

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $splitTheBillId)->first();
            $newPrice = $splitTheBillLinktable->reserved_changed_amount;
            $oldPrice = $splitTheBillLinktable->amount;

            $splitTheBillLinktable->accepted_change = 1;
            $splitTheBillLinktable->membership_package_change_id = null;
            $splitTheBillLinktable->amount = $newPrice;
            $splitTheBillLinktable->reserved_changed_amount = $oldPrice;
            $splitTheBillLinktable->reserved_membership_package_id = null;
            $splitTheBillLinktable->save();

            $mollie = $this->getService("mollie");
            $sub = $user->getMostRecentPayment();
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $subscription = $customer->getSubscription($sub->sub_id);
            $subscription->amount = (object) [
                "currency" => "EUR",
                "value" => number_format($newPrice, 2, ".", "."),
            ];
            $subscription->webhookUrl = $this->getWebhookUrl(true);
            $subscription->startDate = date("Y-m-d", strtotime("+1 month"));
            $subscription->update();

            $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->where("accepted_change", 1)->get();
            if (count($allSplitTheBillLinktables) >= count($user->team->getMembers())) {
                $userChat = UserChat::select("*")->where("receiver_user_id", $user->team->ceo_user_id)->where("creator_user_id", 1)->first();
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $this->getTimeSent();
                if($teamPackage->changed_payment_settings == 1){
                    $userMessage->message = "The verification to change your payment settings has been succesfuly validated by all your members! everything changed automatically you don't have to do anything :)";
                } else {
                    $userMessage->message = "The verification to change your team package has been succesfuly validated by all your members! You can pursue now. have fun!";
                }
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();

                foreach($allSplitTheBillLinktables as $splitTheBillLinktable){
                    $splitTheBillLinktable->accepted_change = 0;
                    $splitTheBillLinktable->membership_package_change_id = null;
                    $splitTheBillLinktable->reserved_changed_amount = null;
                    $splitTheBillLinktable->reserved_membership_package_id = null;
                    $splitTheBillLinktable->reserved_custom_team_package_id = null;
                    $splitTheBillLinktable->custom_package_change_id = null;
                    $splitTheBillLinktable->save();
                }
                $teamPackage->change_package = 0;
                $teamPackage->changed_payment_settings = 0;
                $teamPackage->save();
            }
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function billingAction(){
        if($this->authorized()) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $payments = Payments::select("*")->where("user_id", $user->id)->get();
            $userName = $user->getName();

            if(count($payments) > 0){
                $invoices = Invoice::select("*")->where("user_id", $user->id)->where("hash", $user->hash)->get();
                return view("/public/user/userBilling", compact("user", "payments", "invoices"));
            } else {
                return view("/public/user/userBilling", compact("user"));
            }

        }
    }

    public function rejectChangeAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $user = User::select("*")->where("id", $userId)->first();

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $splitTheBillId)->first();
            $splitTheBillLinktable->accepted_change = 0;
            $splitTheBillLinktable->save();


            $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
            if ($teamPackage->changed_payment_settings != 1) {
                if ($splitTheBillLinktable->reserved_custom_team_package_id == null) {
                    $package = MembershipPackage::select("*")->where("id", $splitTheBillLinktable->reserved_membership_package_id)->first();
                    $teamPackage->title = $package->title;
                    $teamPackage->description = $package->description;
                    $teamPackage->membership_package_id = $package->id;
                    $teamPackage->custom_team_package_id = null;
                } else {
                    $package = CustomTeamPackage::select("*")->where("id", $splitTheBillLinktable->reserved_custom_team_package_id)->first();
                    $teamPackage->custom_team_package_id = $package->id;
                    $teamPackage->membership_package_id = null;
                }
                $teamPackage->price = $splitTheBillLinktable->getFullPackagePrice();
            }
            $teamPackage->change_package = 0;
            $teamPackage->changed_payment_settings = 0;
            $teamPackage->save();

            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->get();
            $userChat = UserChat::select("*")->where("receiver_user_id", $user->team->ceo_user_id)->where("creator_user_id", 1)->first();
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = $userChat->id;
            $userMessage->time_sent = $this->getTimeSent();
            if ($teamPackage->changed_payment_settings == 1) {
                $userMessage->message = $user->getName() . " has rejected the request to change your payment settings. Change has been aborted. still want to change the payment settings? send another request.";
            } else {
                $userMessage->message = $user->getName() . " has rejected the request for the package change. Change has been aborted. still want to change the package? send another request.";
            }
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();

            foreach ($allSplitTheBillLinktables as $splitTheBillLinktable) {
                if($splitTheBillLinktable->accepted_change == 1){
                    $newAmount = $splitTheBillLinktable->reserved_changed_amount;
                    $splitTheBillLinktable->amount = $newAmount;
                    $mollie = $this->getService("mollie");
                    $sub = $splitTheBillLinktable->user->getMostRecentPayment();
                    $customer = $mollie->customers->get($splitTheBillLinktable->user->mollie_customer_id);
                    $subscription = $customer->getSubscription($sub->sub_id);
                    $subscription->amount = (object) [
                        "currency" => "EUR",
                        "value" => number_format($newAmount, 2, ".", "."),
                    ];
                    $subscription->webhookUrl = $this->getWebhookUrl(true);
                    $subscription->update();
                }
                $splitTheBillLinktable->accepted_change = 0;
                $splitTheBillLinktable->membership_package_change_id = null;
                $splitTheBillLinktable->reserved_changed_amount = null;
                $splitTheBillLinktable->reserved_membership_package_id = null;
                $splitTheBillLinktable->reserved_custom_team_package_id = null;
                $splitTheBillLinktable->save();
            }


            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully rejected request");
        }
    }

    public function rejectSplitTheBillAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $teamId = $request->input("team_id");
            $user = User::select("*")->where("id", $userId)->first();
            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $teamId)->get();
            foreach ($allSplitTheBillLinktables as $allSplitTheBillLinktable) {
                $recentPayment = $allSplitTheBillLinktable->user->getMostRecentOpenPayment();
                $recentPayment->payment_status = "Canceled";
                $recentPayment->save();
                $mollie = $this->getService("mollie");
                $mollie->payments->delete($recentPayment->payment_id);

                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $allSplitTheBillLinktable->id)->first();
                $splitTheBillLinktable->accepted = 0;
                $splitTheBillLinktable->save();
            }

            $team = $team = Team::select("*")->where("id", $user->team_id)->first();
            $team->split_the_bill = 0;
            $team->save();

            $this->saveAndSendEmail($user, "Payment has been rejected", view("/templates/sendSplitTheBillRejected", compact("user", "team")));

            $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = $userChat->id;
            $userMessage->time_sent = $this->getTimeSent();
            $userMessage->message = "The payment for your team has been rejected because one of your team members rejected the validation request.";
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function cancelSubscriptionAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $teamId = $request->input("team_id");

            $team = Team::select("*")->where("id", $teamId)->first();
            $user = User::select("*")->where("id", $userId)->first();
            if($team->split_the_bill == 1) {
                $userName = $user->getName();
                $this->saveAndSendEmail($user, "$userName has left your team", view("/templates/sendMemberStopSubLeaveTeam", compact("user", "team")));
            }
            $user->subscription_canceled = 1;
            $user->team_id = null;
            $user->save();

            if($team->split_the_bill == 1){
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $userId)->where("team_id", $teamId)->first();
                $teamLeaderSplitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $team->ceo_user_id)->where("team_id", $teamId)->first();

                $memberAmount =  $splitTheBillLinktable->amount;
                $leaderAmount = $teamLeaderSplitTheBillLinktable->amount;
                $newLeaderPrice = $leaderAmount + $memberAmount;

                $splitTheBillLinktable->delete();

                $mollie = $this->getService("mollie");
                $sub = $teamLeaderSplitTheBillLinktable->user->getMostRecentPayment();
                $customer = $mollie->customers->get($teamLeaderSplitTheBillLinktable->user->mollie_customer_id);
                $subscription = $customer->getSubscription($sub->sub_id);
                $subscription->amount = (object) [
                    "currency" => "EUR",
                    "value" => number_format($newLeaderPrice, 2, ".", "."),
                ];
                $subscription->startDate = date("Y-m-d");
                $subscription->webhookUrl = $this->getWebhookUrl(true);
                $subscription->update();

                $teamLeaderSplitTheBillLinktable->amount = $newLeaderPrice;
                $teamLeaderSplitTheBillLinktable->save();

                $userName = $user->getName();
                $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $this->getTimeSent();
                $userMessage->message = "We are sorry to say that $userName has decided to stop his/her subscription and to leave your team.";
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();
            }
            $mollie = $this->getService("mollie");
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $customer->cancelSubscription($user->getMostRecentPayment()->sub_id);

            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully canceled subscription and left team");
        }
    }

    public function joinTeamFromHelperAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            $user->finished_helper = 1;
            $user->save();

            return redirect("/teams");
        }
    }

    public function finishHelperAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            $user->finished_helper = 1;
            $user->save();

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function passwordForgottenIndex(){
        return view("/public/user/passwordForgotten");
    }

    public function sendPasswordResetLinkAction(Request $request){
        $email = $request->input("email");
        $user = User::select("*")->where("email", $email)->first();
        if($user){
            $user->hash_timestamp = date("Y-m-d H:i:s", strtotime("+1 hour"));
            $user->save();
            $this->saveAndSendEmail($user, "Reset your password", view("/templates/sendResetPassword", compact("user")));

            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("We have sent an email to $email with a password reset link!");
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Couldn't find any account associated with email $email please try again");
        }
    }

    public function resetPasswordIndexAction($hash){
        $user = User::select("*")->where("hash", $hash)->first();
        if($user) {
            $today = date("Y-m-d H");
            $hash_timestamp = date("Y-m-d H", strtotime($user->hash_timestamp));
            if ($today <= $hash_timestamp) {
                return view("/public/user/resetPassword", compact("user"));
            } else {
                return redirect("/login")->withErrors("The password reset link has been expired");
            }
        } else {
            return redirect("/login")->withErrors("Invalid user");
        }
    }

    public function resetPasswordAction(Request $request){
        $userId = $request->input("user_id");
        $password = $request->input("password");
        $confirmPassword = $request->input("confirm_password");

        $user = User::select("*")->where("id", $userId)->first();

        if($password == $confirmPassword){
            $user->password = bcrypt(($request->input("password")));
            $user->hash_timestamp = date("Y-m-d H:i:s", strtotime("-1 hour"));
            $user->save();
            return redirect("/login")->withSuccess("password succesfully changed.You can login now!");
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Passwords don't match");
        }
    }

    public function TeamCreateRequestsAction(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $teamCreateRequests = TeamCreateRequest::select("*")->where("receiver_user_id", $user->id)->get();

        return view("/public/user/teamCreateRequests", compact("user", "teamCreateRequests"));
    }

    public function acceptCreateTeamRequestAction(Request $request){
        $teamRequestId = $request->input("teamCreateRequestId");
        $teamCreateRequest = TeamCreateRequest::select("*")->where("id", $teamRequestId)->first();
        $teamCreateRequest->accepted = 1;
        $teamCreateRequest->save();

        $team_name = $teamCreateRequest->sender->firstname . " and " . $teamCreateRequest->receiver->firstname . " " . "team";
        $team = new Team;
        $team->team_name = ucfirst($team_name);
        $team->slug = str_replace(" ", "-", strtolower($team_name));
        $team->ceo_user_id = $teamCreateRequest->sender_user_id;
        $team->created_at = date("Y-m-d H:i:s");
        $team->team_profile_picture = "defaultProfilePicture.png";
        $team->save();

        $joinRequest = new JoinRequestLinktable();
        $joinRequest->team_id = $team->id;
        $joinRequest->user_id = $teamCreateRequest->receiver_user_id;
        $joinRequest->expertise_id = $teamCreateRequest->receiver->getExpertises()->First()->id;
        $joinRequest->accepted = 1;
        $joinRequest->created_at = date("Y-m-d");
        $joinRequest->save();


        Session::set("team_id", $team->id);
        Session::set("team_name", $team->team_name);

        $sender = User::select("*")->where("id", $teamCreateRequest->sender_user_id)->first();
        $receiver = User::select("*")->where("id", $teamCreateRequest->receiver_user_id)->first();

        $allJoinRequestsSender = JoinRequestLinktable::select("*")->where("user_id", $sender->id)->where("accepted", 0)->get();
        if(count($allJoinRequestsSender) > 0){
            foreach($allJoinRequestsSender as $item){
                $item->accepted = 2;
                $item->save();
            }
        }

        $allJoinRequestsReceiver = JoinRequestLinktable::select("*")->where("user_id", $receiver->id)->where("accepted", 0)->get();
        if(count($allJoinRequestsReceiver) > 0){
            foreach($allJoinRequestsReceiver as $item){
                $item->accepted = 2;
                $item->save();
            }
        }

        $allInvitesSender = InviteRequestLinktable::select("*")->where("user_id", $sender->id)->where("accepted", 0)->get();
        if(count($allInvitesSender) > 0){
            foreach($allInvitesSender as $item){
                $item->accepted = 2;
                $item->save();
            }
        }

        $allInvitesReceiver = InviteRequestLinktable::select("*")->where("user_id", $receiver->id)->where("accepted", 0)->get();
        if(count($allInvitesReceiver) > 0){
            foreach($allInvitesReceiver as $item){
                $item->accepted = 2;
                $item->save();
            }
        }


        $sender->team_id = $team->id;
        $sender->save();

        $receiver->team_id = $team->id;
        $receiver->save();

        $UserChat = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", $sender->id)->first();

        $message = new UserMessage();
        $message->sender_user_id = 1;
        $message->message = "$sender->firstname has accepted to create a team with you! start chatting and with each other and start creating! goodluck!";
        $message->user_chat_id = $UserChat->id;
        $message->time_sent = $this->getTimeSent();
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $user = User::select("*")->where("id", $teamCreateRequest->sender_user_id)->first();
        $this->saveAndSendEmail($sender, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));


        return redirect("/my-team");

    }

    public function rejectCreateTeamRequestAction(Request $request){
        $teamRequestId = $request->input("teamCreateRequestId");
        $teamCreateRequest = TeamCreateRequest::select("*")->where("id", $teamRequestId)->first();
        $teamCreateRequest->accepted = 2;
        $teamCreateRequest->save();

        $sender = User::select("*")->where("id", $teamCreateRequest->sender_user_id)->first();


        $UserChat = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", $sender->id)->first();

        $message = new UserMessage();
        $message->sender_user_id = 1;
        $message->message = "$sender->firstname has declined your request to create a team together. But don't worry there more chances! have a look again at all the InnoCreatives!";
        $message->user_chat_id = $UserChat->id;
        $message->time_sent = $this->getTimeSent();
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();


        $user = User::select("*")->where("id", $teamCreateRequest->sender_user_id)->first();
        $this->saveAndSendEmail($sender, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function followUserAction(Request $request){
        if($this->authorized()){
            $userId = $request->input("user_id");
            $userFollow = new UserFollowLinktable();
            $userFollow->user_id = Session::get("user_id");
            $userFollow->followed_user_id = $userId;
            $userFollow->created_at = date("Y-m-d H:i:s");
            $userFollow->save();

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function unfollowUserAction(Request $request){
        if($this->authorized()){
            $userId = $request->input("user_id");
            $userFollow = UserFollowLinktable::select("*")->where("user_id", Session::get("user_id"))->where("followed_user_id", $userId)->first();
            $userFollow->delete();

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function savePortfolioAsUserWorkAction(Request $request){
        if($this->authorized()){
            $portfolioId = $request->input("portfolio_id");

            $userPortfolio = UserPortfolio::select("*")->where("id", $portfolioId)->first();
            $userPortfolio->posted_as_work = 1;
            $userPortfolio->save();

            $userSlug = $userPortfolio->user->slug;

            $userWork = new UserWork();
            $userWork->user_id = $userPortfolio->user_id;
            $userWork->title = $userPortfolio->title;
            $userWork->description = $userPortfolio->description;
            $userWork->save();

            if($userPortfolio->image != null) {
                Storage::disk('spaces')->copy("users/$userSlug/portfolios/$userPortfolio->image", "users/$userSlug/userworks/$userWork->id/$userPortfolio->image");
                $userWork->content = $userPortfolio->image;
                $userWork->save();
            }

            $userWork->progress = null;
            $userWork->pinned = 0;
            $userWork->upvotes = null;
            $userWork->created_at = date("Y-m-d H:i:s");
            $userWork->save();

            return redirect("/innocreatives/$userWork->id");
        }
    }

    public function declineConnectionAction(Request $request, SwitchUserWork $switch, Mailgun $mailgun){
        $switch->declineConnection($request, $mailgun);
        return redirect ("/account");
    }

    public function acceptConnectionAction(Request $request, SwitchUserWork $switch, Mailgun $mailgun){
        $switch->acceptConnection($request, $mailgun);
        return redirect("/my-account/chats");
    }

    public function removeChatSessionAction(){
        Session::remove("userChatId");
    }

    public function userAccountPrivacySettingsAction(UserPrivacySettings $userPrivacySettings){
        return $userPrivacySettings->userAccountPrivacySettingsIndex();
    }

    public function sendConnectRequestAction(Request $request, SwitchUserWork $switch){
        $switch->createNewConnectRequest($request);
        return redirect('/my-account');
    }
}
