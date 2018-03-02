<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\expertises_linktable;
use App\Favorite_expertises_linktable;
use App\FavoriteTeamLinktable;
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\Team;
use App\TeamReview;
use App\User;
use App\UserMessage;
use App\UserPortfolio;
use App\NeededExpertiseLinktable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
        if(Session::has("user_name")) {
            $id = Session::get("user_id");
            $user = User::select("*")->where("id", $id)->first();
            return view("/public/user/userAccount", compact("user"));
        } else {
            return view("/public/home/home");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccountCredentials()
    {
        if(Session::has("user_name")) {
            $id = Session::get("user_id");
            $user = User::select("*")->where("id", $id)->first();
            return view("/public/user/userAccountCredentials", compact("user"));
        } else {
            return view("/public/home/home");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserAccount(Request $request)
    {
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
    public function userAccountExpertises()
    {
        $user_id = Session::get("user_id");
        $expertises_linktable = expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        $expertises = Expertises::select("*")->get();
        return view("/public/user/userAccountExpertises", compact("expertises_linktable", "user_id", "expertises"));
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
        $user_id = Session::get("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        return view("/public/user/teamBenefits", compact("user"));

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
            $team->ceo_user_id = $user_id;
            $team->created_at = date("Y-m-d H:i:s");
            $team->save();

            $user->team_id = $team->id;
            $user->save();

            Session::set("team_id", $team->id);
            Session::set("team_name", $team->team_name);


            return redirect("/my-team");
        }
    }

    public function favoriteExpertisesUser(){
        $user_id = Session::get("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $expertises = Expertises::select("*")->inRandomOrder()->limit("6")->get();
        $favoriteExpertisesUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        return view("/public/user/favoriteExpertisesUser", compact("expertises", "user", "favoriteExpertisesUser"));
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
        $user_id = Session::get("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $userPortfolios = UserPortfolio::select("*")->where("user_id",$user_id)->get();
        $amountPortfolios = count($userPortfolios);
        return view("/public/user/userAccountPortfolio",compact("userPortfolios", "amountPortfolios", "user"));
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
        $user_id = Session::get("user_id");
        if(request()->has('user_id')){
            $urlParameter = request()->user_id;
        }
        $userMessages = UserMessage::select("*")->where("sender_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->with("Users")->get();
        if(count($userMessages) != 0) {
            return view("/public/user/userAccountChats", compact( "userMessages", "user_id", "urlParameter"));
        }
            return view("/public/user/userAccountChats", compact("user_id"));
    }

    public function searchChatUsers(Request $request){
        // gets all the users where user searched on to chat with

        $user_id = Session::get("user_id");
        $searchInput = $request->input("searchChatUsers");
        $users = User::select("*")->get();
        $idArray = [];
        foreach($users as $user){
            if(strpos($user->getName(), ucfirst($searchInput)) !== false){
                array_push($idArray, $user->id);
            }
        }
        $userMessages = UserMessage::select("*")->where("sender_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->with("Users")->get();
        $searchedUsers = User::select("*")->whereIn("id", $idArray)->get();
            return view("/public/user/userAccountChats", compact("searchedUsers", "user_id","userMessages"));
    }

    public function selectChatUser(Request $request){
        // selects the user. The user wants to chat with and adds it to the database

        $receiver_user_id = $request->input("receiver_user_id");
        $sender_user_id = $request->input("sender_user_id");

        $userMessage = new UserMessage();
        $userMessage->sender_user_id = $sender_user_id;
        $userMessage->receiver_user_id = $receiver_user_id;
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();

        $userMessage = new UserMessage();
        $userMessage->sender_user_id = $receiver_user_id;
        $userMessage->receiver_user_id = $sender_user_id;
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();
        return redirect("/my-account/chats");
    }

    public function sendMessageUserAction(Request $request){
        // sends a message to the user. The user selected. with the sended time and return to the page with id.
        // so the collapse stays open from the user you are chatting with

        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $receiver_user_id = $request->input("receiver_user_id");
        $sender_user_id = $request->input("sender_user_id");
        $userMessages = UserMessage::select("*")->where("receiver_user_id", $receiver_user_id)->where("sender_user_id", $sender_user_id)->orWhere("receiver_user_id", $sender_user_id)->orWhere("sender_user_id", $receiver_user_id)->where("team_id", null)->get();
        if(count($userMessages) > 0) {
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = $sender_user_id;
            $userMessage->receiver_user_id = $receiver_user_id;
            $userMessage->time_sent = $time;
            $userMessage->message = $request->input("message");
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();
        } else {
            $userMessages->message = $request->input("message");
            $userMessages->time_sent = $time;
            $userMessages->save();
        }
        return redirect("/my-account/chats?user_id=$receiver_user_id");

    }

    public function favoriteTeamAction(Request $request){
        $team_id = $request->input("team_id");
        $user_id = Session::get("user_id");
        $favoriteExists = FavoriteTeamLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->first();
        if(count($favoriteExists) == 0) {
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

    public function applyForTeamAction(Request $request){
        $team_id = $request->input("team_id");
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");

        $checkJoinRequests = JoinRequestLinktable::select("*")->where("team_id",$team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
        if(count($checkJoinRequests) == 0) {
            $team = Team::select("*")->where("id", $team_id)->first();

            $joinRequest = new JoinRequestLinktable();
            $joinRequest->team_id = $team_id;
            $joinRequest->user_id = $user_id;
            $joinRequest->expertise_id = $expertise_id;
            $joinRequest->accepted = 0;
            $joinRequest->created_at = date("Y-m-d");
            $joinRequest->save();

            $ceoFirstname = $joinRequest->teams->First()->users->First()->firstname;
            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));

            $message = new UserMessage();
            $message->sender_user_id = $user_id;
            $message->receiver_user_id = $team->ceo_user_id;
            $message->message = "Hey $ceoFirstname I have done a request to join your team!";
            $message->time_sent = $time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $message = new UserMessage();
            $message->sender_user_id = $team->ceo_user_id;
            $message->receiver_user_id = $user_id;
            $message->message = null;
            $message->time_sent = null;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already applied for this team");
        }
    }

    public function userTeamJoinRequestsAction(){
        $user_id = Session::get("user_id");
        $teamJoinRequests = JoinRequestLinktable::select("*")->where("user_id", $user_id)->get();
        $invites = InviteRequestLinktable::select("*")->where("user_id", $user_id)->get();
        return view("/public/user/userTeamJoinRequests", compact("teamJoinRequests","invites", "user_id"));
    }

    public function postTeamReviewAction(Request $request){
        $team_id = $request->input("team_id");
        $user_id = $request->input("user_id");
        $stars_value = $request->input("star_value");

        $reviewMessage = $request->input("review");
        $title = $request->input("review_title");

        $reviews = TeamReview::select("*")->where("team_id", $team_id)->where("writer_user_id", $user_id)->get();
        $team = Team::select("*")->where("id", $team_id)->first();
        if(count($reviews) == 0 && $user_id != $team->ceo_user_id) {

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

            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));
            $message = new UserMessage();
            $message->sender_user_id = $team->ceo_user_id;
            $message->team_id = $team_id;
            $message->message = "$user->firstname has written a new review for this team! go check it out!";
            $message->time_sent = $time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already wrote a review or you are the CEO of this team");
        }
    }

    public function acceptTeamInviteAction(Request $request){
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
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $user = User::select("*")->where("id", $invite->users->First()->id)->first();
        $user->team_id = $invite->team_id;
        $user->save();
        Session::set('team_id', $user->team_id);
        Session::set('team_name', $user->team->team_name);


        $message = new UserMessage();
        $message->sender_user_id = $user->id;
        $message->team_id = $team_id;
        $message->message = "Hey $teamName i am happy to say, that i accepted your invite to join this team.";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }
}
