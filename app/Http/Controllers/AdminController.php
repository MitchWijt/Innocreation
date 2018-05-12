<?php

namespace App\Http\Controllers;

use App\Country;
use App\Expertises;
use App\Expertises_linktable;
use App\ForumMainTopic;
use App\ForumMainTopicType;
use App\ForumThread;
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\NeededExpertiseLinktable;
use App\SupportTicket;
use App\SupportTicketStatus;
use App\Team;
use App\TeamGroupChatLinktable;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\WorkspaceShortTermPlannerTask;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statisticsAction(){
        if($this->authorized(true)){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $totalUsers = User::select("*")->get();
            $totalTeams = Team::select("*")->get();
            $totalTasks = WorkspaceShortTermPlannerTask::select("*")->get();
            $totalMessages = UserMessage::select("*")->get();
            $totalInvited = InviteRequestLinktable::select("*")->get();
            $totalRequests = JoinRequestLinktable::select("*")->get();

            $totalExpertises = Expertises::select("*")->get();
            return view("/admin/statistics", compact("user", "totalUsers", "totalInvited" , "totalMessages", "totalRequests", "totalTasks", "totalTeams", "totalExpertises"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccountsListAction(){
        if($this->authorized(true)){
            $users = User::select("*")->where("deleted", 0)->get();
            return view("/admin/userAccountsList", compact("users"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userEditorAction($id){
        if($this->authorized(true)) {
            $adminUser = User::select("*")->where("id", Session::get("user_id"))->first();
            $user = User::select("*")->where("id", $id)->first();
            $expertiseLinktables = Expertises_linktable::select("*")->where("user_id", $id)->get();
            $countries = Country::select("*")->get();
            return view("/admin/userEditor", compact("user", "countries", "expertiseLinktables", "adminUser"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveUserAction(Request $request){
        if($this->authorized(true)) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->first();

            $user->firstname = $request->input("firstname");
            if(strlen($request->input("middlename")) > 0) {
                $user->middlename = $request->input("middlename");
            }
            $user->lastname = $request->input("lastname");
            $user->email = $request->input("email");
            $user->city = $request->input("city");
            $user->postalcode = $request->input("postal_code");
            $user->state = $request->input("state");
            $user->phonenumber = $request->input("phonenumber");
            $user->country = $request->input("country");
            $user->motivation = $request->input("user_motivation");
            $user->introduction = $request->input("user_introduction");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("test");
        }
    }

    /**
     * Show the form for editing the specifiesd resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveSingleUserExpertiseAction(Request $request){
        if($this->authorized(true)) {
            $expertiseLinktableId = $request->input("expertise_linktable_id");

            $expertiseLinktable = Expertises_linktable::select("*")->where("id", $expertiseLinktableId)->first();
            $expertiseLinktable->description = $request->input("expertise_description");
            $expertiseLinktable->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamListAction(){
        if($this->authorized(true)) {
            $teams = Team::select("*")->get();
            return view("/admin/teamList", compact("teams"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUserAction(Request $request){
        if ($this->authorized(true)) {
            $admin = User::select("*")->where("id", Session::get("admin_user_id"))->first();
            $userId = $request->input("user_id");
            $password = $request->input("password");
            if (Auth::attempt(['email' => $admin->email, 'password' => $password])) {
                $user = User::select("*")->where("id", $userId)->first();
                if($user->team_id != null){
                    $userJoinedExpertise = $user->getJoinedExpertise()->expertises->First()->id;
                    $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $user->team_id)->where("expertise_id", $userJoinedExpertise)->first();
                    $neededExpertise->amount = $neededExpertise->amount + 1;
                }
                $user->delete();

                $userExpertisesLinktable = Expertises_linktable::select("*")->where("user_id", $userId)->get();
                foreach($userExpertisesLinktable as $userExpertise){
                    $userExpertise->delete();
                }

                return redirect("/admin/userAccounts")->with("success","User deleted");
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("Authentication failed");
            }
        }
    }

    public function switchLoginAction(Request $request){
        if ($this->authorized(true)) {
            $userId = $request->input("user_id");
            $user = User::select("*")->where("id", $userId)->with("team")->first();
            Session::set('user_name', $user->getName());
            Session::set('user_id', $user->id);
            if($user->team_id != null) {
                Session::set('team_id', $user->team_id);
                Session::set("team_name", $user->team->first()->team_name);
            }
            return redirect("/account");
        }
    }

    public function deleteUserProfilePictureAction(Request $request){
        if ($this->authorized(true)) {
            $userId = $request->input("user_id");

            $user = User::select("*")->where("id", $userId)->first();
            $user->profile_picture = "defaultProfilePicture.png";
            $user->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function teamEditorAction($id){
        if ($this->authorized(true)) {
            $admin = User::select("*")->where("id", Session::get("admin_user_id"))->where("role", 1)->first();
            $team = Team::select("*")->where("id", $id)->first();
            return view("/admin/teamEditor", compact("team", "admin"));
        }
    }

    public function saveTeamAction(Request $request){
        if ($this->authorized(true)) {
            $teamId = $request->input("team_id");
            $motivation = $request->input("team_motivation");
            $introduction = $request->input("team_introduction");

            $team = Team::select("*")->where("id", $teamId)->First();
            $team->team_motivation = $motivation;
            $team->team_introduction = $introduction;
            $team->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Saved");
        }
    }

    public function sendMessageTeamChatAction(Request $request){
        if ($this->authorized(true)) {
            $teamId = $request->input("team_id");
            $sender_user_id = 1;
            $teamMessage = $request->input("message_team_chat");

            $message = new UserMessage();
            $message->sender_user_id = $sender_user_id;
            $message->team_id = $teamId;
            $message->message = $teamMessage;
            $message->time_sent = $this->getTimeSent();
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Team message sent");
        }
    }

    public function saveNeededExpertiseBackendAction(Request $request){
        if ($this->authorized(true)) {
            $neededExpertiseId = $request->input("needed_expertise_id");
            $description = $request->input("description_needed_expertise");
            $requirements = $request->input("requirements_needed_expertise");
            $amount = $request->input("amount");
            $neededExpertise = NeededExpertiseLinktable::select("*")->where("id", $neededExpertiseId)->first();
            $neededExpertise->description = $description;
            $neededExpertise->requirements = $requirements;
            $neededExpertise->amount = $amount;
            $neededExpertise->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", $neededExpertise->Expertises->First()->title . " updated");
        }
    }

    public function deleteTeamProfilePictureAction(Request $request){
        if ($this->authorized(true)) {
            $teamId = $request->input("team_id");
            $team = Team::select("*")->where("id", $teamId)->first();
            $team->team_profile_picture = "defaultProfilePicture.png";
            $team->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function supportTicketsIndexAction(){
        if ($this->authorized(true)) {
            $admin = User::select("*")->where("id", Session::get("admin_user_id"))->first();
            $supportTickets = SupportTicket::select("*")->orderBy("support_ticket_status_id")->get();
            $supportTicketStatusses = SupportTicketStatus::select("*")->get();
            return view("/admin/supportTickets", compact("supportTickets", "supportTicketStatusses", "admin"));
        }
    }

    public function assignHelperToSupportTicketAction(Request $request){
        if ($this->authorized(true)) {
            $userId = $request->input("user_id");
            $ticketId = $request->input("support_ticket_id");

            $supportTicket = SupportTicket::select("*")->where("id", $ticketId)->first();
            $supportTicket->helper_user_id = $userId;
            $supportTicket->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function changeStatusSupportTicketAction(Request $request){
        if ($this->authorized(true)) {
            $statusId = $request->input("status_id");
            $ticketId = $request->input("ticket_id");

            $supportTicket = SupportTicket::select("*")->where("id", $ticketId)->first();
            $supportTicket->support_ticket_status_id = $statusId;
            $supportTicket->save();

            return $supportTicket->supportTicketStatus->status;
        }
    }

    public function messagesIndexAction(){
        if ($this->authorized(true)) {
            $userChats = UserChat::select("*")->where("creator_user_id", 1)->get();
            return view("/admin/messages", compact("userChats"));
        }
    }

    public function forumMainTopicListAction(){
        if ($this->authorized(true)) {
            $forumMainTopics = ForumMainTopic::select("*")->get();
            return view("/admin/forumMainTopicList", compact("forumMainTopics"));
        }
    }

    public function forumMainTopicEditorAction($id = null){
        if ($this->authorized(true)) {
            $forumMainTopicTypes = ForumMainTopicType::select("*")->get();
            if($id){
                $forumMainTopic = ForumMainTopic::select("*")->where("id", $id)->first();
                return view("/admin/forumMainTopicEditor", compact("forumMainTopic", "forumMainTopicTypes"));
            } else {
                return view("/admin/forumMainTopicEditor", compact("forumMainTopicTypes"));
            }
        }
    }

    public function saveForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $title = $request->input("title");
            $description = $request->input("description");
            $newType = $request->input("newForumMainTopicType");

            if($forumMainTopicId){
                $forumMainTopic = ForumMainTopic::select("*")->where("id", $request->input("forum_main_topic_id"))->first();
                $forumMainTopic->published = 1;
            } else {
                $forumMainTopic = new ForumMainTopic();
                $forumMainTopic->published = 0;
            }

            if($newType){
                $forumMainTopicType = new ForumMainTopicType();
                $forumMainTopicType->title = $newType;
                $forumMainTopicType->save();
                $forumMainTopicTypeId = $forumMainTopicType->id;
            } else {
                $forumMainTopicTypeId = $request->input("forumMainTopicType");
            }

            $forumMainTopic->main_topic_type_id = $forumMainTopicTypeId;
            $forumMainTopic->title = $title;
            $forumMainTopic->description = $description;
            $forumMainTopic->save();
            return redirect("/admin/forumMainTopicEditor/$forumMainTopic->id")->with("success", "Saved");
        }
    }

    public function publishForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $forumMainTopic = ForumMainTopic::select("*")->where("id", $forumMainTopicId)->first();
            $forumMainTopic->published = 1;
            $forumMainTopic->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function hideForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $forumMainTopic = ForumMainTopic::select("*")->where("id", $forumMainTopicId)->first();
            $forumMainTopic->published = 0;
            $forumMainTopic->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function deleteForumMainTopicAction(Request $request){
        if ($this->authorized(true)) {
            $forumMainTopicId = $request->input("forum_main_topic_id");
            $forumMainTopic = ForumMainTopic::select("*")->where("id", $forumMainTopicId)->first();
            $forumMainTopic->delete();
            return redirect("/admin/forumMainTopicList")->with("success", "Topic deleted");
        }
    }

    public function forumThreadListAction(){
        if ($this->authorized(true)) {
            $forumThreads = ForumThread::select("*")->get();
            return view("/admin/forumThreadList", compact("forumThreads"));
        }
    }

    public function deleteForumThreadAction(Request $request){
        if ($this->authorized(true)) {
            $forumThreadId = $request->input("forum_thread_id");
            $forumThread = ForumThread::select("*")->where("id", $forumThreadId)->first();
            $forumThread->delete();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thread deleted");
        }
    }

    public function closeForumThreadAction(Request $request){
        if ($this->authorized(true)) {
            $forumThreadId = $request->input("forum_thread_id");
            $forumThread = ForumThread::select("*")->where("id", $forumThreadId)->first();
            $forumThread->closed = 1;
            $forumThread->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thread closed");
        }
    }

    public function openForumThreadAction(Request $request){
        if ($this->authorized(true)) {
            $forumThreadId = $request->input("forum_thread_id");
            $forumThread = ForumThread::select("*")->where("id", $forumThreadId)->first();
            $forumThread->closed = 0;
            $forumThread->save();
            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Thread opened");
        }
    }
}
