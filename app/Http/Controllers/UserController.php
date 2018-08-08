<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\Favorite_expertises_linktable;
use App\FavoriteTeamLinktable;
use App\InviteRequestLinktable;
use App\Invoice;
use App\JoinRequestLinktable;
use App\Page;
use App\ServiceReview;
use App\SplitTheBillLinktable;
use App\SupportTicket;
use App\SupportTicketMessage;
use App\Team;
use App\TeamReview;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\Payments;
use App\UserPortfolio;
use App\TeamPackage;
use App\NeededExpertiseLinktable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Middleware\RolesMiddleware;


use App\Http\Requests;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccount()
    {
        if($this->authorized()) {
            if (Session::has("user_name")) {
                $id = Session::get("user_id");
                $user = User::select("*")->where("id", $id)->first();
                return view("/public/user/userAccount", compact("user"));
            } else {
                return view("/public/home/home");
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccountCredentials(){
        if($this->authorized()) {
            if (Session::has("user_name")) {
                $id = Session::get("user_id");
                $user = User::select("*")->where("id", $id)->first();
                return view("/public/user/userAccountCredentials", compact("user"));
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
        $user->save();
        return redirect($_SERVER["HTTP_REFERER"]);
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

    public function addUserExpertiseAction(Request $request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise");
        $experience = $request->input("expertise_description");

        $expertise_linktable = new expertises_linktable();
        $expertise_linktable->user_id = $user_id;
        $expertise_linktable->expertise_id = $expertise_id;
        $expertise_linktable->description = $experience;
        $expertise_linktable->save();
        return redirect($_SERVER["HTTP_REFERER"]);
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
    public function createNewTeam(Request $request)
    {
        $team_name = $request->input("team_name");
        $user_id = $request->input("user_id");
        $all_teams = Team::select("*")->where("team_name", $team_name)->get();
        $user = User::select("*")->where("id", $user_id)->first();
        if(count($all_teams) != 0){
            $error = "This name already exists";
            return view("/public/user/teamBenefits", compact("error", "user"));
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

    public function saveFavoriteExperisesUser(Request $request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $existingFavExpertises = Favorite_expertises_linktable::select("*")->where("user_id",$user_id)->where("expertise_id", $expertise_id)->first();
        $AllFavUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->get();
        if(count($AllFavUser) >= 4){
            return "max";
        } else {
            if (count($existingFavExpertises == 0)) {
                $favoriteExpertise = new Favorite_expertises_linktable;
                $favoriteExpertise->user_id = $user_id;
                $favoriteExpertise->expertise_id = $expertise_id;
                $favoriteExpertise->save();
                return $favoriteExpertise->expertise_id;
            } else {
                return 2;
            }
        }
    }

    public function deleteFavoriteExpertisesUser(Request $request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $favoriteExpertises = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->where("expertise_id", $expertise_id)->first();
        $favoriteExpertises->delete();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function saveUserProfilePictureAction(Request $request){
        $user_id = $request->input("user_id");
        $file = $request->file("profile_picture");
        $destinationPath = public_path().'/images/profilePicturesUsers';
        $fullname = $file->getClientOriginalName();

        $user = User::select("*")->where("id", $user_id)->first();
        $user->profile_picture = $fullname;
        $user->save();
        $file->move($destinationPath, $fullname);
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function userAccountPortfolio(){
        if($this->authorized()) {
            $user_id = Session::get("user_id");
            $user = User::select("*")->where("id", $user_id)->first();
            $userPortfolios = UserPortfolio::select("*")->where("user_id", $user_id)->get();
            $amountPortfolios = count($userPortfolios);
            return view("/public/user/userAccountPortfolio", compact("userPortfolios", "amountPortfolios", "user"));
        }
    }

    public function saveUseraccountPortfolio(Request $request){
        $destinationPath = public_path().'/images/portfolioImages';

        $user_id = $request->input("user_id");
        $portfolio_titles = $request->input("portfolio_title");
        $portfolio_image = $request->file("portfolio_image");
        $portfolio_links = $request->file("portfolio_link");
        $portfolio_descriptions = $request->input("description_portfolio");


        if($portfolio_image[0] != null) {

            $rowCount = count($portfolio_titles);

            for ($i = 0; $i < $rowCount; $i++) {
                $portfolio_image[$i]->move($destinationPath, $portfolio_image[$i]->getClientOriginalName());
                $userPortfolio = new UserPortfolio;
                $userPortfolio->user_id = $user_id;
                $userPortfolio->title = $portfolio_titles[$i];
                $userPortfolio->description = $portfolio_descriptions[$i];
                $userPortfolio->image = $portfolio_image[$i]->getClientOriginalName();
                if($portfolio_links != null) {
                    $userPortfolio->link = $portfolio_links[$i];
                }
                $userPortfolio->save();
            }
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function editUserPortfolio(Request $request){
        $portfolio_id = $request->input("portfolio_id");
        $image = $request->file("portfolio_image");
        $title = $request->input("portfolio_title");
        $description = $request->input("description_portfolio");
        $link = $request->input("portfolio_link");

        $userPortfolio = UserPortfolio::select("*")->where("id",$portfolio_id)->first();
        $userPortfolio->title = $title;
        $userPortfolio->description = $description;
        if($image != null){
            $destinationPath = public_path().'/images/portfolioImages';
            $userPortfolio->image = $image->getClientOriginalName();
            $image->move($destinationPath,$image->getClientOriginalName());
        }
        if($link != null){
            $userPortfolio->link = $link;
        }
        $userPortfolio->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteUserPortfolio(Request $request){
        $portfolio_id = $request->input("portfolio_id");
        $userPortfolio = UserPortfolio::select("*")->where("id", $portfolio_id)->first();
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
            }
            $innocreationChat = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", 1)->first();
            $userChats = UserChat::select("*")->where("creator_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->get();
            if (count($userChats) != 0) {
                return view("/public/user/userAccountChats", compact("userChats", "user_id", "urlParameter", "urlParameterChat", "innocreationChat"));
            }
            return view("/public/user/userAccountChats", compact("user_id", "inn"));
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

            $users = User::select("*")->get();
            $userChats = UserChat::select("*")->where("creator_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->get();
            if (strlen($searchInput) > 0) {
                $idArray = [];
                foreach ($users as $user) {
                    if (strpos($user->getName(), ucfirst($searchInput)) !== false) {
                        array_push($idArray, $user->id);
                    }
                }
                $searchedUsers = User::select("*")->whereIn("id", $idArray)->get();
            } else {
                $searchInput = false;
            }
            return view("/public/user/userAccountChats", compact("searchedUsers", "user_id", "userChats"));
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
            }
            return redirect("/my-account/chats");
        }
    }

    public function sendMessageUserAction(Request $request){
        if($this->authorized()) {
            // sends a message to the user. The user selected. with the sended time and return to the page with id.
            // so the collapse stays open from the user you are chatting with

            $user_chat_id = $request->input("user_chat_id");
            $sender_user_id = $request->input("sender_user_id");
            $message = $request->input("message");

            $userChat = UserChat::select("*")->where("id", $user_chat_id)->first();

            $userMessage = new UserMessage();
            $userMessage->sender_user_id = $sender_user_id;
            $userMessage->user_chat_id = $user_chat_id;
            $userMessage->time_sent = $this->getTimeSent();
            $userMessage->message = $request->input("message");
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();

            $messageArray = ["message" => $message, "timeSent" => $this->getTimeSent()];
            echo json_encode($messageArray);
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

                $ceoFirstname = $team->user->firstname;

                $existingUserChat = UserChat::select("*")->where("creator_user_id", $user_id)->where("receiver_user_id",  $joinRequest->team->ceo_user_id)->orWhere("creator_user_id",  $joinRequest->team->ceo_user_id)->where("receiver_user_id", $user_id)->get();
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
                $this->saveAndSendEmail($joinRequest->teams->users, "Team join request from $user->firstname!", view("/templates/sendJoinRequestToTeam", compact("user", "team")));

                return redirect($_SERVER["HTTP_REFERER"]);
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already applied for this team");
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
            $encryptedData = $request->input("adyen-encrypted-data");
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $termsPayment = $request->input("paymentTermsCheck");

            $referenceObject = Payments::select("*")->orderBy("id", "DESC")->first();
            $reference = $referenceObject->reference + 1;

            if($termsPayment == 1){
                $user = User::select("*")->where("id", $userId)->first();
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
                if($user->payment_refused == 1){
                    $price = str_replace(".", "", number_format($splitTheBillLinktable->amount, 2, ".", "."));

                    //RECURRINGSTORECALL
                    $data = array("additionalData" => array("card.encrypted.json" => $encryptedData), "amount" => array("value" => $price, "currency" => "EUR"), "reference" => $reference, "merchantAccount" => "InnocreationNET", "shopperReference" => $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id, "recurring" => array("contract" => "RECURRING"), "selectedRecurringDetailReference" =>  $splitTheBillLinktable->user->getMostRecentPayment()->recurring_detail_reference, "shopperInteraction" => "ContAuth");
                    $data_string = json_encode($data);

                    $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                            'Content-Type: application/json',
                            'Content-Length:' . strlen($data_string))
                    );
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                    //execute post
                    $result = curl_exec($ch);
                    $resultAuthorization = json_decode($result);
                    $resultCode = $resultAuthorization->resultCode;
                    $pspReference = $resultAuthorization->pspReference;
                    //close connection
                    curl_close($ch);

                    //Cancel all payments
                    if ($resultCode == "Refused") {
                        $status = "Canceled";
                        $data = array("merchantAccount" => "InnocreationNET", "originalReference" => $pspReference);
                        $data_string = json_encode($data);

                        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: Basic '. base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                                'Content-Type: application/json',
                                'Content-Length:' . strlen($data_string))
                        );
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                        //execute post
                        $result = curl_exec($ch);
                        $resultAuthorization = json_decode($result);
                        //close connection
                        curl_close($ch);


                        $splitTheBillLinktable->accepted = 0;
                        $splitTheBillLinktable->save();
                        return redirect($_SERVER["HTTP_REFERER"])->withErrors("Your credit card credentials seem to be invalid, to continue check your credentials and please try again");
                    } else {
                        $user = User::select("*")->where("id", $userId)->first();
                        $user->subscription_canceled = 0;
                        $user->save();

                        $status = "Settled";
                        //RECURRINGDETAILS
                        $data = array("merchantAccount" => "InnocreationNET", "shopperReference" => $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id);
                        $data_string = json_encode($data);

                        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Recurring/v25/listRecurringDetails');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                                'Content-Type: application/json',
                                'Content-Length:' . strlen($data_string))
                        );
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                        //execute post
                        $result = curl_exec($ch);
                        $resultAuthorization = json_decode($result);
                        $recurringDetailReference = $resultAuthorization->details[0]->RecurringDetail->recurringDetailReference;

                        //close connection
                        curl_close($ch);


                        $team = $team = Team::select("*")->where("id", $user->team_id)->first();
                        $this->saveAndSendEmail($user,  "Payment successfully pursued", view("/templates/sendSplitTheBillSuccess", compact("user", "team")));

                        $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
                        $userMessage = new UserMessage();
                        $userMessage->sender_user_id = 1;
                        $userMessage->user_chat_id = $userChat->id;
                        $userMessage->time_sent = $this->getTimeSent();
                        $userMessage->message = "The payment for your team has successfully been pursued! Enjoy and make great innovative products!";
                        $userMessage->created_at = date("Y-m-d H:i:s");
                        $userMessage->save();

                        $splitTheBillLinktable->accepted = 1;
                        $splitTheBillLinktable->save();

                        $user = User::select("*")->where("id", $userId)->first();
                        $user->payment_refused = 0;
                        $user->save();
                    }
                    $details = end($resultAuthorization->details);
                    $card = $details->RecurringDetail->card;
                    $paymentMethod = $details->RecurringDetail->paymentMethodVariant;

                    $payment = new Payments();
                    $payment->user_id = $splitTheBillLinktable->user->id;
                    $payment->team_id = $splitTheBillLinktable->team->id;
                    $payment->payment_method = $paymentMethod;
                    $payment->card_number = $card->number;
                    $payment->amount = $price;
                    $payment->shopper_reference = $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id;
                    $payment->recurring_detail_reference = $recurringDetailReference;
                    $payment->pspReference = $pspReference;
                    $payment->reference = $reference;
                    $payment->payment_status = $status;
                    $payment->created_at = date("Y-m-d H:i:s");
                    $payment->save();
                    return redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
                    $payment = Payments::select("*")->orderBy("id", "DESC")->first();
                    $reference = $payment->reference + 1;
                    $price = str_replace(".", "", number_format($splitTheBillLinktable->amount, 2, ".", "."));

                    //RECURRINGSTORECALL
                    $data = array("additionalData" => array("card.encrypted.json" => $encryptedData), "amount" => array("value" => $price, "currency" => "EUR"), "reference" => $reference, "merchantAccount" => "InnocreationNET", "shopperReference" => $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id, "recurring" => array("contract" => "RECURRING"));
                    $data_string = json_encode($data);

                    $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                            'Content-Type: application/json',
                            'Content-Length:' . strlen($data_string))
                    );
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                    //execute post
                    $result = curl_exec($ch);
                    $resultAuthorization = json_decode($result);
                    $resultCode = $resultAuthorization->resultCode;
                    $pspReference = $resultAuthorization->pspReference;
                    if (isset($resultAuthorization->resultCode)) {
                    }
                    //close connection
                    curl_close($ch);

                    //Cancel all payments
                    if ($resultCode == "Refused") {
                        $payment = new Payments();
                        $payment->user_id = $user->id;
                        $payment->team_id = $user->team_id;
                        $payment->amount = $price;
                        $payment->recurring_detail_reference = null;
                        $payment->shopper_reference = $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id;
                        $payment->reference = $reference;
                        $payment->pspReference = $pspReference;
                        $payment->payment_status = "Canceled";
                        $payment->created_at = date("Y-m-d H:i:s");
                        $payment->save();

                        $data = array("merchantAccount" => "InnocreationNET", "originalReference" => $pspReference);
                        $data_string = json_encode($data);

                        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                                'Content-Type: application/json',
                                'Content-Length:' . strlen($data_string))
                        );
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                        //execute post
                        $result = curl_exec($ch);
                        $resultAuthorization = json_decode($result);
                        //close connection
                        curl_close($ch);
                        return redirect($_SERVER["HTTP_REFERER"])->withErrors("Your credit card credentials seem to be invalid, to continue check your credentials and please try again");
                    } else {
                        $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $splitTheBillId)->first();
                        $splitTheBillLinktable->accepted = 1;
                        $splitTheBillLinktable->save();
                        //RECURRINGDETAILS
                        $data = array("merchantAccount" => "InnocreationNET", "shopperReference" => $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id);
                        $data_string = json_encode($data);

                        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Recurring/v25/listRecurringDetails');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                                'Content-Type: application/json',
                                'Content-Length:' . strlen($data_string))
                        );
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                        //execute post
                        $result = curl_exec($ch);
                        $resultAuthorization = json_decode($result);

                        $recurringDetailReference = $resultAuthorization->details[0]->RecurringDetail->recurringDetailReference;

                        //close connection
                        curl_close($ch);

                        $details = end($resultAuthorization->details);
                        $card = $details->RecurringDetail->card;
                        $paymentMethod = $details->RecurringDetail->paymentMethodVariant;

                        $payment = new Payments();
                        $payment->user_id = $splitTheBillLinktable->user->id;
                        $payment->team_id = $splitTheBillLinktable->team->id;
                        $payment->payment_method = $paymentMethod;
                        $payment->card_number = $card->number;
                        $payment->amount = $price;
                        $payment->shopper_reference = $splitTheBillLinktable->user->getName() . $splitTheBillLinktable->team->id;
                        $payment->recurring_detail_reference = $recurringDetailReference;
                        $payment->pspReference = $pspReference;
                        $payment->reference = $reference;
                        $payment->payment_status = "Authorized";
                        $payment->created_at = date("Y-m-d H:i:s");
                        $payment->save();
                    }

                    $counterAuthorised = 0;
                    $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->get();
                    foreach($allSplitTheBillLinktables as $allSplitTheBillLinktable){
                        if($allSplitTheBillLinktable->user->getMostRecentAuthPayment()){
                            $counterAuthorised++;
                        }
                    }
                    if($counterAuthorised >= count($user->team->getMembers())) {
                        foreach ($allSplitTheBillLinktables as $allSplitTheBillLinktable) {
                            $recentPayment = $allSplitTheBillLinktable->user->getMostRecentAuthPayment();
                            $recentPayment->payment_status = "Settled";
                            $recentPayment->save();

                            $teamPackage = TeamPackage::select("*")->where("team_id", $allSplitTheBillLinktable->team_id)->first();
                            $invoiceNumber = Invoice::select("*")->orderBy("invoice_number", "DESC")->first()->invoice_number;
                            $invoice = new Invoice();
                            $invoice->user_id = $allSplitTheBillLinktable->user_id;
                            $invoice->team_id = $allSplitTheBillLinktable->team_id;
                            $invoice->team_package_id = $teamPackage->id;
                            $invoice->amount = $allSplitTheBillLinktable->amount;
                            $invoice->hash = $allSplitTheBillLinktable->user->hash;
                            $invoice->invoice_number = $invoiceNumber + 1;
                            $invoice->paid_date = date("Y-m-d", strtotime("+2 days"));
                            $invoice->created_at = date("Y-m-d H:i:s");
                            $invoice->save();
                        }

                        $team = $team = Team::select("*")->where("id", $user->team_id)->first();
                        $this->saveAndSendEmail($user, "Payment successfully pursued", view("/templates/sendSplitTheBillSuccess", compact("user", "team")));

                        $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
                        $userMessage = new UserMessage();
                        $userMessage->sender_user_id = 1;
                        $userMessage->user_chat_id = $userChat->id;
                        $userMessage->time_sent = $this->getTimeSent();
                        $userMessage->message = "The payment for your team has successfully been pursued! Enjoy and make great innovative products!";
                        $userMessage->created_at = date("Y-m-d H:i:s");
                        $userMessage->save();
                        return redirect($_SERVER["HTTP_REFERER"]);
                    } else {
                        return redirect($_SERVER["HTTP_REFERER"]);
                    }

                }
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("Agree with the Term of payment to continue");
            }
        }
    }

    public function validateChangeAction(Request $request){
        if($this->authorized()) {
            $userId = $request->input("user_id");
            $splitTheBillId = $request->input("split_the_bill_linktable_id");
            $user = User::select("*")->where("id", $userId)->first();

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $splitTheBillId)->first();
            $splitTheBillLinktable->accepted_change = 1;
            $splitTheBillLinktable->save();

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
                    $newPrice = $splitTheBillLinktable->reserved_changed_amount;
                    $splitTheBillLinktable->accepted_change = 0;
                    $splitTheBillLinktable->membership_package_change_id = null;
                    $splitTheBillLinktable->amount = $newPrice;
                    $splitTheBillLinktable->reserved_changed_amount = null;
                    $splitTheBillLinktable->reserved_membership_package_id = null;
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
                $data = array("merchantAccount" => "InnocreationNET", "shopperReference" => $userName . $user->team_id);
                $data_string = json_encode($data);

                $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Recurring/v25/listRecurringDetails');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                        'Content-Type: application/json',
                        'Content-Length:' . strlen($data_string))
                );
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                //execute post
                $result = curl_exec($ch);
                if($result != '{}') {
                    $resultAuthorization = json_decode($result);
                    $recurringDetailReference = $resultAuthorization->details[0]->RecurringDetail->recurringDetailReference;
                    $details = end($resultAuthorization->details);
                    $card = $details->RecurringDetail->card;
                    $paymentMethod = $details->RecurringDetail->paymentMethodVariant;
                }
                //close connection
                curl_close($ch);

                $invoices = Invoice::select("*")->where("user_id", $user->id)->where("hash", $user->hash)->get();
                if($result == '{}'){
                    return view("/public/user/userBilling", compact("user", "payments", "invoices"));
                } else {
                    return view("/public/user/userBilling", compact("user", "payments", "card", "paymentMethod", "invoices"));
                }
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
            $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->get();
            $userChat = UserChat::select("*")->where("receiver_user_id", $user->team->ceo_user_id)->where("creator_user_id", 1)->first();
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = $userChat->id;
            $userMessage->time_sent = $this->getTimeSent();
            if ($teamPackage->changed_payment_details == 1) {
                $userMessage->message = $user->getName() . " has rejected the request to change your payment settings. Change has been aborted. still want to change the payment settings? send another request.";
            } else {
                $userMessage->message = $user->getName() . " has rejected the request for the package change. Change has been aborted. still want to change the package? send another request.";
            }
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();

            foreach ($allSplitTheBillLinktables as $splitTheBillLinktable) {
                $splitTheBillLinktable->accepted_change = 0;
                $splitTheBillLinktable->membership_package_change_id = null;
                $splitTheBillLinktable->reserved_changed_amount = null;
                $splitTheBillLinktable->reserved_membership_package_id = null;
                $splitTheBillLinktable->save();
            }

            $teamPackage->change_package = 0;
            $teamPackage->change_payment_settings = 0;
            $teamPackage->save();

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
                if ($allSplitTheBillLinktable->accepted == 1) {
                    $recentPayment = $allSplitTheBillLinktable->user->getMostRecentAuthPayment();
                    $recentPayment->payment_status = "Canceled";
                    $recentPayment->save();

                    $data = array("merchantAccount" => "InnocreationNET", "originalReference" => $recentPayment->pspReference);
                    $data_string = json_encode($data);

                    $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                            'Content-Type: application/json',
                            'Content-Length:' . strlen($data_string))
                    );
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                    //execute post
                    $result = curl_exec($ch);
                    $resultAuthorization = json_decode($result);
                    //close connection
                    curl_close($ch);
                }
            }

            $team = $team = Team::select("*")->where("id", $user->team_id)->first();
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

            $user = User::select("*")->where("id", $userId)->first();
            $user->subscription_canceled = 1;
            $user->team_id = null;
            $user->save();

            $team = Team::select("*")->where("id", $teamId)->first();
            if($team->split_the_bill == 1){
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $userId)->where("team_id", $teamId)->first();
                $teamLeaderSplitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $team->ceo_user_id)->where("team_id", $teamId)->first();

                $memberAmount =  $splitTheBillLinktable->amount;
                $leaderAmount = $teamLeaderSplitTheBillLinktable->amount;
                $newLeaderPrice = $leaderAmount + $memberAmount;

                $splitTheBillLinktable->delete();

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
                $this->saveAndSendEmail($user, "$userName has left your team", view("/templates/sendMemberStopSubLeaveTeam", compact("user", "team")));

            }

            $data = array("merchantAccount" => "InnocreationNET", "shopperReference" => $user->getName() . $teamId, "recurringDetailReference" => $user->getMostRecentPayment()->recurring_detail_reference);
            $data_string = json_encode($data);

            $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Recurring/v25/disable');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                    'Content-Type: application/json',
                    'Content-Length:' . strlen($data_string))
            );
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

            //execute post
            $result = curl_exec($ch);
            //close connection
            curl_close($ch);
        }
    }
}
