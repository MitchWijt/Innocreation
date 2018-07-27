<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\MailMessage;
use App\NeededExpertiseLinktable;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamGroupChat;
use App\TeamGroupChatLinktable;
use App\TeamProduct;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserRole;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamPageCredentials()
    {
        // gets the user and team and gives them to the view

        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        return view("/public/team/teamPageCredentials", compact("team","user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveTeamProfilePictureAction(Request $request)
    {
        // grabs the uploaded file moves it into the correct folder and adds it to the database for the team
        $team_id = $request->input("team_id");


        $file = $request->file("profile_picture");
        $destinationPath = public_path().'/images/profilePicturesTeams';
        $fullname = $file->getClientOriginalName();

        $team = Team::select("*")->where("id", $team_id)->first();
        $team->team_profile_picture = $fullname;
        $team->save();
        $file->move($destinationPath, $fullname);
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveTeamPageAction(Request $request)
    {
        // saves the description and motivation of the team (perhaps more in the future)
        $team_id = $request->input("team_id");

        $introduction = $request->input("introduction_team");
        $motivation = $request->input("motivation_team");

        $team = Team::select("*")->where("id", $team_id)->first();
        $team->team_introduction = $introduction;
        $team->team_motivation = $motivation;
        $team->updated_at = date("Y-m-d H:i:s");
        $team->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function neededExpertisesAction()
    {
        // gets all the needed expertised for the team
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $expertises = Expertises::select("*")->get();
        return view("/public/team/neededExpertisesTeam", compact("team","expertises", "user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNeededExpertiseAction(Request $request)
    {
        // Grabs the team id and expertise the team wants to add and adds it to the database for the team. Also checks for doubles
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertises");
        $amount = $request->input("amountNewExpertise");
        $expertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        if(count($expertise) == 0) {
            $neededExpertise = new NeededExpertiseLinktable();
            $neededExpertise->team_id = $team_id;
            $neededExpertise->expertise_id = $expertise_id;
            $neededExpertise->amount = $amount;
            $neededExpertise->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $error = "Already added this expertise. Please choose a new one";
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Already added this expertise. Please choose a new one");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveNeededExpertiseAction(Request $request)
    {
        // saves the description + requirements for the expertises the team decided to change
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertise_id");
        $requirements = $request->input("requirements");
        $amountNeeded = $request->input("amountExpertise");
        $description = $request->input("description_needed_expertise");
        $requirementString = "";
        foreach($requirements as $requirement){
            if($requirement != "") {
                if ($requirementString == "") {
                    $requirementString = $requirement;
                } else {
                    $requirementString = $requirementString . "," . $requirement;
                }
            }
        }

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->requirements = $requirementString;
        $neededExpertise->description = $description;
        $neededExpertise->amount = $amountNeeded;
        $neededExpertise->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteNeededExpertiseAction(Request $request){
        // Grabs the needed expertise chosen and deletes the expertise from Database.

        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertise_id");

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->delete();
        return 1;
    }

    public function teamUserJoinRequestsAction(){
        // gets all the join requests for the team
        $user_id = Session::get("user_id");
        $team_id = Session::get("team_id");
        $userJoinRequests = JoinRequestLinktable::select("*")->where("team_id", $team_id)->get();
        $invites = InviteRequestLinktable::select("*")->where("team_id", $team_id)->get();
        return view("/public/team/teamUserJoinRequests", compact("userJoinRequests", "user_id", "invites"));
    }

    public function rejectUserFromTeamAction(Request $request){
        // Rejects user from team
        // sends user a message for rejection
        $request_id = $request->input("request_id");
        $request = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
        $request->accepted = 2;
        $request->save();

        $userName = $request->users->First()->getName();
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $userChat = UserChat::select("*")->where("creator_user_id", $request->user_id)->first();
        $message = new UserMessage();
        $message->sender_user_id = $request->teams->first()->ceo_user_id;
        $message->user_chat_id = $userChat->id;
        $message->message = "Hey $userName unfortunately we decided to reject you from our team";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    public function acceptUserInteamAction(Request $request){
        // accepts user into team
        // sends user message that he is welcome in team
        // checks if user is requested for any other team. and rejects the user at that team

            $user_id = $request->input("user_id");
            $request_id = $request->input("request_id");
            $expertise_id = $request->input("expertise_id");
            $team_id = $request->input("team_id");
            $request = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
            $request->accepted = 1;
            $request->save();

            $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
            $neededExpertise->amount = $neededExpertise->amount - 1;
            $neededExpertise->save();

            $otherRequests = JoinRequestLinktable::select("*")->where("user_id", $user_id)->where("accepted", 0)->get();
            if (count($otherRequests) > 0) {
                foreach ($otherRequests as $otherRequest) {
                    $otherRequest->accepted = 2;
                    $otherRequest->save();
                }
            }

            $userName = $request->users->First()->getName();
            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));

            $user = User::select("*")->where("id", $request->users->First()->id)->first();
            $user->team_id = $request->team_id;
            $user->save();

            $existingUserChat = UserChat::select("*")->where("creator_user_id", $user->id)->where("receiver_user_id",  $request->teams->first()->ceo_user_id)->orWhere("creator_user_id",  $request->teams->first()->ceo_user_id)->where("receiver_user_id", $user->id)->get();
            if(count($existingUserChat) > 0){
                $userChat = new UserChat();
                $userChat->creator_user_id = $request->teams->first()->ceo_user_id;
                $userChat->receiver_user_id = $user->id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                $userChatId = $userChat->id;
            } else {
                $userChatId = $existingUserChat->id;
            }
            $message = new UserMessage();
            $message->sender_user_id = $request->teams->first()->ceo_user_id;
            $message->user_chat_id = $userChatId;
            $message->message = "Hey $userName we are happy to say, that we accepted you in our team. Welcome!";
            $message->time_sent = $time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            return redirect($_SERVER["HTTP_REFERER"]);

    }

    public function inviteUserForTeamAction(Request $request){
        $team_id = $request->input("team_id");
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");

        $checkJoinInvites = InviteRequestLinktable::select("*")->where("team_id",$team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
        if(count($checkJoinInvites) == 0) {
            $team = Team::select("*")->where("id", $team_id)->first();

            $invite = new InviteRequestLinktable();
            $invite->team_id = $team_id;
            $invite->user_id = $user_id;
            $invite->expertise_id = $expertise_id;
            $invite->accepted = 0;
            $invite->created_at = date("Y-m-d");
            $invite->save();

            $userFirstName = $invite->users->First()->firstname;
            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));

            $existingUserChat = UserChat::select("*")->where("creator_user_id", $user_id)->where("receiver_user_id",  $invite->teams->ceo_user_id)->orWhere("creator_user_id",  $invite->teams->ceo_user_id)->where("receiver_user_id", $user_id)->get();
            if(count($existingUserChat) < 1){
                $userChat = new UserChat();
                $userChat->creator_user_id = $invite->teams->ceo_user_id;
                $userChat->receiver_user_id = $user_id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                $userChatId = $userChat->id;
            } else {
                $userChatId = $existingUserChat->First()->id;
            }
            $message = new UserMessage();
            $message->sender_user_id = $invite->teams->ceo_user_id;
            $message->user_chat_id = $userChatId;
            $message->message = "Hey $userFirstName I have done an invite to you to join my team!";
            $message->time_sent = $time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $receiver = User::select("*")->where("id", $user_id)->first();

            $this->saveAndSendEmail($receiver, "Team invite from $team->team_name!", view("/templates/sendInviteToUserMail", compact("receiver", "team")));

            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already sent an invite to this user");
        }
    }

    public function teamMembersPage(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $teamRoles = UserRole::select("*")->where("team_role", 1)->get();
        return view("/public/team/teamPageMembers", compact("team", "user","teamRoles"));
    }

    public function kickMemberFromTeamAction(Request $request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("joined_expertise_id");
        $kickMessage = $request->input("kickMessage");

        $team = Team::select("*")->where("id", $team_id)->first();

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->amount = $neededExpertise->amount +1;
        $neededExpertise->save();

        $user = User::select("*")->where("id", $user_id)->first();
        $user->team_id = null;
        $user->save();

        $joinrequest = JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 1)->first();
        if(!$joinrequest){
            $joinrequest = InviteRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 1)->first();
        }
        $joinrequest->delete();

        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $message = new UserMessage();
        $message->sender_user_id =  $team->ceo_user_id;
        $message->receiver_user_id = $user_id;
        $message->message = "Your kick reason: " . $kickMessage;
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $message = new UserMessage();
        $message->sender_user_id = $user_id;
        $message->receiver_user_id = $team->ceo_user_id;
        $message->message = null;
        $message->time_sent = null;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function teamChatAction(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $messages = UserMessage::select("*")->where("team_id", $team->id)->get();

        foreach($messages as $message){
            $message->seen_at = date("Y-m-d H:i:s");
            $message->save();
        }
        $groupChats = TeamGroupChatLinktable::select("*")->where("user_id", $user->id)->where("team_id", $team->id)->get();

        if(request()->has('group_chat_id')){
            $urlParameter = request()->group_chat_id;
        }
        return view("/public/team/teamPageChat", compact("team", "user","groupChats","urlParameter"));
    }

    public function sendTeamMessageAction(Request $request){
        $team_id = $request->input("team_id");
        $sender_user_id = $request->input("sender_user_id");
        $teamMessage = $request->input("teamMessage");

        $message = new UserMessage();
        $message->sender_user_id = $sender_user_id;
        $message->team_id = $team_id;
        $message->message = $teamMessage;
        $message->time_sent = $this->getTimeSent();
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function addUsersToGroupChatAction(Request $request){
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();

        $userArray = ['user_id' => $user->id, 'user_name' => $user->getName()];

        return json_encode($userArray);
    }

    public function removeUserFromGroupChatAction(Request $request){
        $user_id = $request->input("user_id");
        $group_chat_id = $request->input("group_chat_id");
        $groupChat = TeamGroupChatLinktable::select("*")->where("team_group_chat_id", $group_chat_id)->where("user_id", $user_id)->first();
        $groupChat->delete();
        return 1;
    }

    public function saveGroupChatTeamAction(Request $request){
        $groupChatMembers = $request->input("groupChatUsersInput");
        $title = $request->input("group_chat_title");
        $group_chat_id = $request->input("group_chat_id");
        $team_id = $request->input("team_id");

        if($groupChatMembers != null) {
            foreach ($groupChatMembers as $groupChatMember) {
                $groupChat = new TeamGroupChatLinktable();
                $groupChat->user_id = $groupChatMember;
                $groupChat->team_id = $team_id;
                $groupChat->team_group_chat_id = $group_chat_id;
                $groupChat->save();
            }
        }

        $group = TeamGroupChat::select("*")->where("id", $group_chat_id)->first();
        $group->title = $title;
        $group->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteGroupChatTeamAction(Request $request){
        $group_id = $request->input("group_chat_id");

        $group = TeamGroupChat::select("*")->where("id", $group_id)->first();
        $group->delete();

        $groupChatLinktables = TeamGroupChatLinktable::select("*")->where("team_group_chat_id", $group_id)->get();
        foreach ($groupChatLinktables as $groupChatLinktable) {
            $groupChatLinktable->delete();
        }

        $messages = UserMessage::select("*")->where("team_group_chat_id", $group_id)->get();
        foreach($messages as $message){
            $message->delete();
        }
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function createGroupChatAction(Request $request){
        $groupChat = new TeamGroupChat();
        $groupChat->title = $request->input("group_title");
        $groupChat->created_at = date("Y-m-d H:i:s");
        $groupChat->save();

        $team_id = $request->input("team_id");

        $groupChatLinktableCreator = new TeamGroupChatLinktable();
        $groupChatLinktableCreator->user_id = Session::get("user_id");
        $groupChatLinktableCreator->team_id = $team_id;
        $groupChatLinktableCreator->team_group_chat_id = $groupChat->id;
        $groupChatLinktableCreator->save();

        foreach($request->input("groupChatUsersInput") as $groupChatUser){
            $groupChatLinktable = new TeamGroupChatLinktable();
            $groupChatLinktable->user_id = $groupChatUser;
            $groupChatLinktable->team_id = $team_id;
            $groupChatLinktable->team_group_chat_id = $groupChat->id;
            $groupChatLinktable->save();
        }

        return redirect($_SERVER["HTTP_REFERER"]);

    }

    public function sendMessageTeamGroupChatAction(Request $request){
        $sender_user_id = $request->input("sender_user_id");
        $chat_group_id = $request->input("chat_group_id");
        $groupChatmessage = $request->input("message");

        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $message = new UserMessage();
        $message->sender_user_id =  $sender_user_id;
        $message->team_group_chat_id = $chat_group_id;
        $message->message = $groupChatmessage;
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        return redirect("/my-team/team-chat?group_chat_id=$chat_group_id");

    }

    public function uploadProfilePictureTeamGroupChatAction(Request $request){

        $group_chat_id = $request->input("group_chat_id");


        $file = $request->file("profile_picture_group_chat");
        $destinationPath = public_path().'/images/teamGroupChatProfilePictures';
        $fullname = $file->getClientOriginalName();

        $groupChat = TeamGroupChat::select("*")->where("id", $group_chat_id)->first();
        $groupChat->profile_picture = $fullname;
        $groupChat->save();
        $file->move($destinationPath, $fullname);
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function muteMemberFromTeamChatAction(Request $request){
        $user_id = $request->input("user_id");
        $hours = $request->input("hours");
        $minutes = $request->input("minutes");

        $mutedTime = date("Y-m-d H:i:s", strtotime("+$hours hours +$minutes minutes"));
        $user = User::select("*")->where("id", $user_id)->first();
        $user->muted = $mutedTime;
        $user->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function unmuteMemberFromTeamChatAction(Request $request){
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $user->muted = date("Y-m-d H:i:s");
        $user->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function editMemberPermissionsAction(Request $request){
        $role = $request->input("teamRole");
        $user_id = $request->input("user_id");

        $member = User::select("*")->where("id", $user_id)->first();
        $member->role = $role;
        $member->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function teamProductsIndexAction(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $teamProducts = TeamProduct::select("*")->where("team_id", $team->id)->get();

        return view("/public/team/teamPageTeamProducts", compact("teamProducts", "team"));

    }

    public function saveTeamProductAction(Request $request){
        $teamProductId = $request->input("team_product_id");
        $teamId = $request->input("team_id");
        $productName = $request->input("product_name");
        $productImage = $request->file("product_image");
        $productDescription = $request->input("product_description");

        if(!$teamProductId) {
            $teamProduct = new TeamProduct();
            $teamProduct->team_id = $teamId;
        } else {
            $teamProduct = TeamProduct::select("*")->where("id", $teamProductId)->first();
        }
        $teamProduct->title = $productName;
        $teamProduct->description = $productDescription;
        if($productImage != null) {
            $teamProduct->image = $productImage->getClientOriginalName();
            $destinationPath = public_path().'/images/teamProductImages';
            $productImage->move($destinationPath,$productImage->getClientOriginalName());
        } else {
            $teamProduct->image = null;
        }
        $teamProduct->slug = str_replace(" ", "-",strtolower($productName));
        $teamProduct->created_at = date("Y-m-d H:i:s");
        $teamProduct->save();

        return redirect($_SERVER["HTTP_REFERER"])->with("success", "succesfully saved your product!");

    }

    public function getTeamProductModalDataAction(Request $request){
        $teamProductId = $request->input("team_product_id");
        $teamProduct = TeamProduct::select("*")->where("id", $teamProductId)->first();
        return view("/public/team/shared/_teamProductModalData", compact("teamProduct"));
    }

    public function deleteTeamProductAction(Request $request){
        $teamProductId = $request->input("team_product_id");
        $teamProduct = TeamProduct::select("*")->where("id", $teamProductId)->first();
        $teamProduct->delete();
    }

    public function teamPaymentDetailsAction(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();

        $splitTheBillDetails = SplitTheBillLinktable::select("*")->where("team_id", $team->id)->get();
        return view("/public/team/teamPaymentDetails", compact("splitTheBillDetails", "team"));
    }
}
