<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\MailMessage;
use App\NeededExpertiseLinktable;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamGroupChat;
use App\TeamGroupChatLinktable;
use App\TeamPackage;
use App\TeamProduct;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Services\TeamServices\CredentialService as CredentialService;
use App\Services\AppServices\MailgunService as MailgunService;
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
    public function saveTeamProfilePictureAction(Request $request){
        // grabs the uploaded file moves it into the correct folder and adds it to the database for the team
        $team_id = $request->input("team_id");
        $file = $request->file("profile_picture");
        $size = $this->formatBytes($file->getSize());
        if($size < 8) {
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
            $team = Team::select("*")->where("id", $team_id)->first();
            $exists = Storage::disk('spaces')->exists("teams/" . $team->slug . "/profilepicture/" . $filename);
            if (!$exists) {
                Storage::disk('spaces')->delete("teams/" . $team->slug . "/profilepicture/" . $team->team_profile_picture);
                $image = $request->file('profile_picture');
                Storage::disk('spaces')->put("teams/" . $team->slug . "/profilepicture/" . $filename, file_get_contents($image->getRealPath()), "public");
            }
            $team->team_profile_picture = $filename;
            $team->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect("/account")->withErrors("Image is too large. The max upload size is 8MB");
        }
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

    public function saveTeamNameAction(Request $request, CredentialService $credentialService){
        return $credentialService->saveTeamName($request);
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
    public function addNeededExpertiseAction(Request $request, MailgunService $mailgunService)
    {
        // Grabs the team id and expertise the team wants to add and adds it to the database for the team. Also checks for doubles
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertises");
        $amount = $request->input("amountNewExpertise");
        $expertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $team = Team::select("*")->where("id", $team_id)->first();
        $expertiseObject = Expertises::select("*")->where("id", $expertise_id)->First();
        if(count($expertise) == 0) {
            $neededExpertise = new NeededExpertiseLinktable();
            $neededExpertise->team_id = $team_id;
            $neededExpertise->expertise_id = $expertise_id;
            $neededExpertise->amount = $amount;
            $neededExpertise->save();

            $expertiseLinktables = Expertises_linktable::select("*")->where("expertise_id", $expertise_id)->get();
            foreach($expertiseLinktables as $expertiseLinktable){
                if($expertiseLinktable->users->First()) {
                    if ($expertiseLinktable->users->First()->notifications == 1) {
                        $user = $expertiseLinktable->users;
                        $userChat = UserChat::select("*")->where("receiver_user_id", $user->First()->id)->where("creator_user_id", 1)->first();
                        if ($userChat) {
                            $userMessage = new UserMessage();
                            $userMessage->sender_user_id = 1;
                            $userMessage->user_chat_id = $userChat->id;
                            $userMessage->time_sent = $this->getTimeSent();
                            $userMessage->message = sprintf('%s is now looking for a %s. <br><br> You can be the first one to join their team at <a href="https://secret.innocreation.net%s">https://secret.innocreation.net%s</a>', $team->team_name, $expertiseObject->title, $team->getUrl(), $team->getUrl());
                            $userMessage->created_at = date("Y-m-d H:i:s");
                            $userMessage->save();

                            $user = $user->First();
                            echo $user->id;
                            die();
                            $mailgunService->saveAndSendEmail($user, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));
                        }
                    }
                }
            }
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
            $joinRequest = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
            $joinRequest->accepted = 1;
            $joinRequest->save();

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

            $userName = $joinRequest->user->getName();
            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));

            $user = User::select("*")->where("id", $joinRequest->user->id)->first();
            $user->team_id = $joinRequest->team_id;
            $user->subscription_canceled = 0;
            $user->save();

            $existingUserChat = UserChat::select("*")->where("creator_user_id", $user->id)->where("receiver_user_id",  $joinRequest->team->ceo_user_id)->orWhere("creator_user_id",  $joinRequest->team->ceo_user_id)->where("receiver_user_id", $user->id)->first();
            if(count($existingUserChat) < 1){
                $userChat = new UserChat();
                $userChat->creator_user_id = $joinRequest->team->ceo_user_id;
                $userChat->receiver_user_id = $user->id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                $userChatId = $userChat->id;
            } else {
                $userChatId = $existingUserChat->id;
            }
            $message = new UserMessage();
            $message->sender_user_id = $joinRequest->team->ceo_user_id;
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
        $title = "My team members. Join my team!";
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $teamRoles = UserRole::select("*")->where("team_role", 1)->get();
        return view("/public/team/teamPageMembers", compact("team", "user","teamRoles", "title"));
    }

    public function kickMemberFromTeamAction(Request $request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("joined_expertise_id");
        $kickMessage = $request->input("kickMessage");

        $team = Team::select("*")->where("id", $team_id)->first();

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->amount = $neededExpertise->amount + 1;
        $neededExpertise->save();

        $user = User::select("*")->where("id", $user_id)->first();
        $user->team_id = null;
        $user->save();

        $joinrequest = JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 1)->first();
        if(!$joinrequest){
            $joinrequest = InviteRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 1)->first();
        }
        if($joinrequest) {
            $joinrequest->delete();
        }

        if($team->split_the_bill == 1 && $user->getMostRecentPayment()){
            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $team->id)->first();
            if($splitTheBillLinktable) {
                $teamLeaderSplitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $team->ceo_user_id)->where("team_id", $team->id)->first();

                $memberAmount = $splitTheBillLinktable->amount;
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
                $subscription->webhookUrl = $this->getWebhookUrl(true);
                $subscription->update();

                $teamLeaderSplitTheBillLinktable->amount = $newLeaderPrice;
                $teamLeaderSplitTheBillLinktable->save();
            }

            $mollie = $this->getService("mollie");
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $customer->cancelSubscription($user->getMostRecentPayment()->sub_id);

            $user->subscription_canceled = 1;
            $user->save();
        }

        $userChat = UserChat::select("*")->where("receiver_user_id", $user->id)->where("creator_user_id", 1)->first();
        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = $userChat->id;
        $userMessage->time_sent = $this->getTimeSent();
        $userMessage->message = "We are sorry to say that $team->team_name has decided to kick you from their team. their reason is: $kickMessage";
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();

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
        $groupChat = TeamGroupChat::select("*")->where("id", $group_chat_id)->first();
        $groupChatLinktable = TeamGroupChatLinktable::select("*")->where("team_group_chat_id", $group_chat_id)->first();
        $size = $this->formatBytes($file->getSize());
        if ($size < 8) {
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
            $exists = Storage::disk('spaces')->exists("teams/" . $groupChatLinktable->team->slug . "/groupchats/" . strtolower(str_replace(" ", "-", $groupChat->title)) . "/" . $filename);
            if (!$exists) {
                Storage::disk('spaces')->delete("teams/" . $groupChatLinktable->team->slug . "/groupchats/" . strtolower(str_replace(" ", "-", $groupChat->title)) . "/" . $groupChat->profile_picture);
                Storage::disk('spaces')->put("teams/" . $groupChatLinktable->team->slug .  "/groupchats/" . strtolower(str_replace(" ", "-", $groupChat->title)) . "/" . $filename, file_get_contents($file->getRealPath()), "public");
            }
            $groupChat->profile_picture = $filename;
            $groupChat->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect("/account")->withErrors("Image is too large. The max upload size is 8MB");
        }
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
        $file = $request->file("product_image");
        $productDescription = $request->input("product_description");

        if(!$teamProductId) {
            $teamProduct = new TeamProduct();
            $teamProduct->team_id = $teamId;
        } else {
            $teamProduct = TeamProduct::select("*")->where("id", $teamProductId)->first();
        }
        $teamProduct->title = $productName;
        $teamProduct->description = $productDescription;
        if($file != null) {
            $size = $this->formatBytes($file->getSize());
            if($size < 8) {
                $filename = str_replace(" ", "-",strtolower($productName)) . "." . $file->getClientOriginalExtension();
                $team = Team::select("*")->where("id", $teamId)->first();
                $exists = Storage::disk('spaces')->exists("teams/" . $team->slug . "/team_products/" . $filename);
                if ($exists) {
                    Storage::disk('spaces')->delete("teams/" . $team->slug . "/team_products/" . $filename);
                }
                Storage::disk('spaces')->put("teams/" . $team->slug . "/team_products/" . $filename, file_get_contents($file->getRealPath()), "public");
                $team->team_profile_picture = $filename;
                $team->save();
            } else {
                return redirect("/account")->withErrors("Image is too large. The max upload size is 8MB");
            }
            $teamProduct->image = $filename;
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
        $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();

        $splitTheBillDetails = SplitTheBillLinktable::select("*")->where("team_id", $team->id)->get();
        return view("/public/team/teamPaymentDetails", compact("splitTheBillDetails", "team", "teamPackage"));
    }

    public function teamPaymentSettingsAction(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();

        return view("/public/team/teamPaymentSettings", compact("user", "teamPackage", "team"));
    }

    public function savePaymentSettingsAction(Request $request){
        $teamId = $request->input("team_id");
        $splitTheBill = $request->input("splitTheBillOnOff");
        $team = Team::select("*")->where("id", $teamId)->first();
        if ($splitTheBill == 1) {
            foreach (Session::get("splitTheBillData") as $key => $value) {
                $existingSplitTheBill = SplitTheBillLinktable::select("*")->where("user_id", $key)->where("team_id", $teamId)->first();
                if (count($existingSplitTheBill) > 0) {
                    $splitTheBillLinktable = $existingSplitTheBill;
                    $splitTheBillLinktable->reserved_changed_amount = $value;
                } else {
                    $splitTheBillLinktable = new SplitTheBillLinktable();
                    $splitTheBillLinktable->accepted = 0;
                    $splitTheBillLinktable->accepted_change = 1;
                    $splitTheBillLinktable->amount = $value;
                }
                $splitTheBillLinktable->user_id = $key;
                $splitTheBillLinktable->team_id = $teamId;
                $splitTheBillLinktable->created_at = date("Y-m-d H:i:s");
                $splitTheBillLinktable->save();
            }
            $team->split_the_bill = 1;

            $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
            $teamPackage->changed_payment_settings = 1;
            $teamPackage->save();
        } else {
            $team->split_the_bill = 0;
        }
        $team->save();
        return redirect($_SERVER["HTTP_REFERER"])->with("success", "succesfully saved your settings!");
    }

    public function generateInviteLinkAction(Request $request){
        $teamId = $request->input("team_id");
        $team = Team::select("*")->where("id", $teamId)->first();

        $team->hash = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
        $team->timestamp = date("Y-m-d H:i:s");
        $team->save();

        $link = "https://innocreation.net" . "/invite/$team->hash/" . $team->slug;

        return $link;
    }
}
