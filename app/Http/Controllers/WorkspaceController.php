<?php

namespace App\Http\Controllers;

use App\AssistanceTicket;
use App\AssistanceTicketMessage;
use App\Team;
use App\User;
use App\UserMessage;
use App\WorkspaceBucketlist;
use App\WorkspaceBucketlistType;
use App\WorkspaceIdeas;
use App\WorkspaceShortTermPlannerBoard;
use App\WorkspaceShortTermPlannerTask;
use App\WorkspaceShortTermPlannerType;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;
use Session;

use App\Http\Requests;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        return view("/public/team/workspace/workspaceIntroduction", compact("team"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workplaceIdeasAction()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $workplaceIdeas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->get();
        return view("/public/team/workspace/workspaceIdeas", compact("team" , "user","workplaceIdeas"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeIdeaStatusAction(Request $request)
    {
        $idea_id = $request->input("idea_id");
        $status = $request->input("status");
        $workplaceIdea = WorkspaceIdeas::select("*")->where("id", $idea_id)->first();
        $workplaceIdea->status = $status;
        $workplaceIdea->save();

        return $workplaceIdea->status;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNewIdeaAction(Request $request)
    {
        $team_id = $request->input("team_id");
        $creator_user_id = $request->input("creator_user_id");
        $title = $request->input("workspace_idea_title");
        $description = $request->input("workspace_idea_description");

        $workspaceIdea = new WorkspaceIdeas();
        $workspaceIdea->team_id = $team_id;
        $workspaceIdea->creator_user_id = $creator_user_id;
        $workspaceIdea->title = $title;
        $workspaceIdea->status = "On hold";
        $workspaceIdea->description = $description;
        $workspaceIdea->created_at = date("Y-m-d H:i:s");
        $workspaceIdea->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function workplaceBucketlistAction()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $workspaceBucketlistTypes = WorkspaceBucketlistType::select("*")->where("team_id", $team->id)->orWhere("team_id", 0)->get();
        return view("/public/team/workspace/workspaceBucketlist", compact("team" , "user", "workspaceBucketlistTypes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNewBucketlistGoalAction(Request $request)
    {
        $team_id = $request->input("team_id");
        $title = $request->input("goal_title");
        $description = $request->input("goal_description");
        $bucketlist_type = $request->input("bucketlist_type");

        $workspaceBucketlist = new WorkspaceBucketlist();
        $workspaceBucketlist->team_id = $team_id;
        $workspaceBucketlist->title = $title;
        $workspaceBucketlist->workspace_bucketlist_type = $bucketlist_type;
        $workspaceBucketlist->description = $description;
        $workspaceBucketlist->created_at = date("Y-m-d H:i:s");
        $workspaceBucketlist->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addBucketlistBoardAction(Request $request)
    {
        $team_id = $request->input("team_id");
        $bucketlistType_name = $request->input("bucketlistType_title");

        $bucketlistType = new WorkspaceBucketlistType();
        $bucketlistType->team_id = $team_id;
        $bucketlistType->name = $bucketlistType_name;
        $bucketlistType->save();

        return $bucketlistType;

    }

    public function completeBucketlistGoalAction(Request $request){
        $bucketlist_id = $request->input("bucketlist_id");

        $existingWorkspaceBucketlists = WorkspaceBucketlist::select("*")->where("id", $bucketlist_id)->where("completed", 1)->get();

        if(count($existingWorkspaceBucketlists) == 0 ) {
            $workspaceBucketlist = WorkspaceBucketlist::select("*")->where("id", $bucketlist_id)->first();
            $workspaceBucketlist->completed = 1;
            $workspaceBucketlist->save();

            return 1;
        } else {
            foreach($existingWorkspaceBucketlists as $existingWorkspaceBucketlist) {
                $existingWorkspaceBucketlist->completed = 0;
                $existingWorkspaceBucketlist->save();
            }
            return 2;
        }
    }

    public function deleteBucketlistBoardAction(Request $request){
        $bucketlist_type_id = $request->input("bucketlist_type_id");
        $bucketlistType = WorkspaceBucketlistType::select("*")->where("id", $bucketlist_type_id)->first();
        $workspaceBucketlistItems = WorkspaceBucketlist::select("*")->where("workspace_bucketlist_type", $bucketlist_type_id)->get();
        if(count($workspaceBucketlistItems) > 0) {
            foreach ($workspaceBucketlistItems as $workspaceBucketlistItem) {
                $workspaceBucketlistItem->delete();
            }
        }
        $bucketlistType->delete();
    }

    public function renameBucketlistBoardAction(Request $request){
        $bucketlist_type_id = $request->input("bucketlist_type_id");
        $new_title = $request->input("new_title");

        $bucketlistType = WorkspaceBucketlistType::select("*")->where("id", $bucketlist_type_id)->first();
        $bucketlistType->name = $new_title;
        $bucketlistType->save();
    }

    public function changePlaceBucketlistGoalAction(Request $request){
        $bucketlist_type_id = $request->input("bucketlist_type_id");
        $bucketlist_id = $request->input("bucketlist_id");

        $workspaceBucketlist = WorkspaceBucketlist::select("*")->where("id", $bucketlist_id)->first();
        $workspaceBucketlist->workspace_bucketlist_type = $bucketlist_type_id;
        $workspaceBucketlist->save();


    }

    public function deleteSingleBucketlistGoalAction(Request $request){
        $bucketlist_id = $request->input("bucketlist_id");

        $workspaceBucketlist = WorkspaceBucketlist::select("*")->where("id", $bucketlist_id)->first();
        $workspaceBucketlist->delete();
    }

    public function workspaceShortTermPlannerOptionPicker(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $workspaceShortTermPlannerTypes = WorkspaceShortTermPlannerType::select("*")->get();
        return view("/public/team/workspace/workspaceShortTermPlannerOptionPicker", compact("team", "user", "workspaceShortTermPlannerTypes"));
    }

    public function addNewShortTermPlannerBoardAction(Request $request){
        $team_id = $request->input("team_id");
        $short_term_planner_type = $request->input("short_term_planner_type");

        $workspaceShortTermPlannerType = WorkspaceShortTermPlannerType::select("*")->where("id", $short_term_planner_type)->first();

        $shortTermPlannerBoard = new WorkspaceShortTermPlannerBoard();
        $shortTermPlannerBoard->title = $workspaceShortTermPlannerType->title;
        $shortTermPlannerBoard->team_id = $team_id;
        $shortTermPlannerBoard->short_term_planner_type = $short_term_planner_type;
        $shortTermPlannerBoard->created_at = date("Y-m-d H:i:s");
        $shortTermPlannerBoard->save();

        return redirect("/my-team/workspace/short-term-planner/$shortTermPlannerBoard->id");

    }

    public function workspaceShortTermPlannerBoard($id){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        if(request()->has('task_id')){
            $urlParameter = request()->task_id;
        }
        $shortTermPlannerBoard = WorkspaceShortTermPlannerBoard::select("*")->where("id", $id)->first();
        $allShortTermPlannerBoards = WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $team->id)->get();
        $shortTermPlannerTasks = WorkspaceShortTermPlannerTask::select("*")->where("short_term_planner_board_id", $shortTermPlannerBoard->id)->orderBy("priority", "DESC")->get();
        $uncompletedBucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team->id)->where("completed", 0)->where("used_on_short_term_planner", 0)->get();
        $passedIdeas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->where("status", "Passed")->where("used_on_short_term_planner", 0)->get();
        return view("/public/team/workspace/workspaceShortTermPlannerBoard", compact("team", "user", "shortTermPlannerBoard", "shortTermPlannerTasks", "uncompletedBucketlistGoals", "passedIdeas","allShortTermPlannerBoards", "urlParameter"));
    }

    public function addShortTermPlannerTaskAction(Request $request){
        $creator_user_id = $request->input("creator_user_id");
        $category = $request->input("task_category");
        $board_id = $request->input("board_id");
        $title = $request->input("title");

        $shortTermPlannerTask = new WorkspaceShortTermPlannerTask();
        $shortTermPlannerTask->creator_user_id = $creator_user_id;
        $shortTermPlannerTask->short_term_planner_board_id = $board_id;
        $shortTermPlannerTask->title = $title;
        $shortTermPlannerTask->category = $category;
        $shortTermPlannerTask->due_date = null;
        $shortTermPlannerTask->created_at = date("Y-m-d H:i:s");
        $shortTermPlannerTask->save();

        return $shortTermPlannerTask->id;
    }

    public function setShortTermPlannerTaskDueDateAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");
        $due_date = $request->input("due_date");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->due_date = date("Y-m-d", strtotime($due_date));
        $shortTermPlannerTask->save();

        return date("d F Y", strtotime($shortTermPlannerTask->due_date));
    }

    public function removeShortTermPlannerTaskDueDateAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->due_date = NULL;
        $shortTermPlannerTask->save();
    }

    public function assignTaskToMemberShortTermPlannerAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");
        $member_user_id = $request->input("member_user_id");


        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        if($member_user_id != "nobody") {
            $shortTermPlannerTask->assigned_to = $member_user_id;
        } else {
            $shortTermPlannerTask->assigned_to = null;
        }
        $shortTermPlannerTask->save();
        if($member_user_id != "nobody") {
            return $shortTermPlannerTask->assignedUser->getProfilePicture();
        }
    }

    public function changePlaceShortTermPlannerTaskAction(Request $request){
        $short_term_planner_task_id = $request->input("short_term_planner_task_id");
        $category = $request->input("category");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->category = $category;
        $shortTermPlannerTask->save();
    }

    public function menuTaskToShortTermPlannerAction(Request $request) {
        $menu_task_id = $request->input("menu_task_id");
        $category = $request->input("category");
        $short_term_planner_board_id = $request->input("board_id");
        $menu_task_category = $request->input("menu_task_category");
        $ideaBool = false;
        $bucketlistBool = false;

        if($menu_task_category == "idea"){
            $workspaceIdea = WorkspaceIdeas::select("*")->where("id", $menu_task_id)->first();
            $ideaBool = true;
            $workspaceIdea->used_on_short_term_planner = 1;
            $workspaceIdea->save();
        } else if($menu_task_category == "bucketlist") {
            $bucketlistBool = true;
            $workspaceBucketlist = WorkspaceBucketlist::select("*")->where("id", $menu_task_id)->first();
            $workspaceBucketlist->used_on_short_term_planner = 1;
            $workspaceBucketlist->save();
        }

        $shortTermPlannerTask = new WorkspaceShortTermPlannerTask();
        $shortTermPlannerTask->creator_user_id = Session::get("user_id");
        $shortTermPlannerTask->short_term_planner_board_id = $short_term_planner_board_id;
        if($ideaBool){
            $shortTermPlannerTask->title = $workspaceIdea->title;
        } else if($bucketlistBool){
            $shortTermPlannerTask->title = $workspaceBucketlist->title;
        }
        $shortTermPlannerTask->category = $category;
        $shortTermPlannerTask->created_at = date("Y-m-d H:i:s");
        $shortTermPlannerTask->save();

        return $shortTermPlannerTask->id;
    }

    public function changeShortTermPlannerBoardTitleAction(Request $request){
        $short_term_planner_board_id = $request->input("board_id");
        $title = $request->input("title");

        $shortTermPlannerBoard = WorkspaceShortTermPlannerBoard::select("*")->where("id", $short_term_planner_board_id)->first();
        $shortTermPlannerBoard->title = $title;
        $shortTermPlannerBoard->save();
    }

    public function saveShortTermPlannerTaskDescriptionAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");
        $description = $request->input("description");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->description = $description;
        $shortTermPlannerTask->save();

        return $shortTermPlannerTask->description;
    }

    public function deleteShortTermPlannerTaskAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->delete();

    }

    public function completeShortTermPlannerTaskAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");


        $alreadyCompleted = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->where("completed", 1)->get();
        if(count($alreadyCompleted) == 0) {
            $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
            $shortTermPlannerTask->completed = 1;
            $shortTermPlannerTask->save();
            return 1;
        } else {
            $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
            $shortTermPlannerTask->completed = 0;
            $shortTermPlannerTask->save();
            return 2;
        }
    }

    public function setPriorityShortTermPlannerTaskAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");
        $priority = $request->input("priority");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->priority = $priority;
        $shortTermPlannerTask->save();

        if($priority == 1){
            return "High";
        } else if($priority == 2){
            return "Medium";
        } else if($priority == 3){
            return "Low";
        }
    }

    public function workspacePersonalBoard(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();

        $today = date("Y-m-d");
        $missedDueDateTasks = [];
        $completedTasks = [];
        $toDoTasks = [];

        $shortTermPlannerTasksToDo = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $user->id)->where("completed", 0)->get();
        $shortTermPlannerTasksComplete = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $user->id)->where("completed", 1)->get();
        $shortTermPlannerTasksDueDate = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $user->id)->where("due_date", "!=", null)->where("completed", 0)->get();

        foreach($shortTermPlannerTasksDueDate as $shortTermPlannerTask){
            if(strtotime($today) > strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->due_date)))){
                array_push($missedDueDateTasks, $shortTermPlannerTask);
            }
        }

        foreach($shortTermPlannerTasksToDo as $shortTermPlannerTask){
            if($shortTermPlannerTask->due_date != null) {
                if (strtotime($today) < strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->due_date)))) {
                    array_push($toDoTasks, $shortTermPlannerTask);
                }
            } else {
                array_push($toDoTasks, $shortTermPlannerTask);
            }
        }

        foreach($shortTermPlannerTasksComplete as $shortTermPlannerTask){
            array_push($completedTasks, $shortTermPlannerTask);
        }
        return view("/public/team/workspace/workspacePersonalBoard", compact("user", "team", "toDoTasks", "completedTasks", "missedDueDateTasks"));
    }

    public function completeTaskPersonalBoardAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->completed = 1;
        $shortTermPlannerTask->save();
    }

    public function uncompleteTaskPersonalBoardAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");

        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();
        $shortTermPlannerTask->completed = 0;
        $shortTermPlannerTask->save();
    }

    public function askForAssistanceAction(Request $request){
        $short_term_planner_task_id = $request->input("task_id");
        $team_id = $request->input("team_id");
        $user_id = $request->input("user_id");
        $receiver_user_id = $request->input("assistanceMembers");
        $message = $request->input("assistance_message");


        $shortTermPlannerTask = WorkspaceShortTermPlannerTask::select("*")->where("id", $short_term_planner_task_id)->first();

        $assistanceTicket = new AssistanceTicket();
        $assistanceTicket->team_id = $team_id;
        $assistanceTicket->task_id = $short_term_planner_task_id;
        $assistanceTicket->creator_user_id = $user_id;
        $assistanceTicket->receiver_user_id = $receiver_user_id;
        $assistanceTicket->title = $shortTermPlannerTask->title;
        $assistanceTicket->created_at = date("Y-m-d H:i:s");
        $assistanceTicket->save();

        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $assistanceTicketMessage = new AssistanceTicketMessage();
        $assistanceTicketMessage->assistance_ticket_id = $assistanceTicket->id;
        $assistanceTicketMessage->sender_user_id = $user_id;
        $assistanceTicketMessage->receiver_user_id = $receiver_user_id;
        $assistanceTicketMessage->message = $message;
        $assistanceTicketMessage->time_sent = $time;
        $assistanceTicketMessage->created_at = date("Y-m-d H:i:s");
        $assistanceTicketMessage->save();
        return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Succesfully created assistance request , check your ticket <a href='/my-team/workspace/assistance-requests' class='regular-link'>here</a>");
    }

    public function workspaceAssistanceTickets(Request $request){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();

        $receivedAssistanceTickets = AssistanceTicket::select("*")->where("receiver_user_id", $user->id)->where("completed", 0)->get();
        $sendedAssistanceTickets = AssistanceTicket::select("*")->where("creator_user_id", $user->id)->where("completed", 0)->get();
        $completedAssistanceTickets = AssistanceTicket::select("*")->where("creator_user_id", $user->id)->where("completed", 1)->orWhere("receiver_user_id", $user->id)->where("completed", 1)->get();


        return view("/public/team/workspace/workspaceAssistanceTickets", compact("user", "team", "receivedAssistanceTickets", "sendedAssistanceTickets", "completedAssistanceTickets"));
    }

    public function sendAssistanceTicketMessageAction(Request $request){
        $ticket_id = $request->input("ticket_id");
        $sender_user_id = $request->input("sender_user_id");
        $receiver_user_id = $request->input("receiver_user_id");
        $message = $request->input("message");

        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $assistanceTicketMessage = new AssistanceTicketMessage();
        $assistanceTicketMessage->assistance_ticket_id = $ticket_id;
        $assistanceTicketMessage->sender_user_id = $sender_user_id;
        $assistanceTicketMessage->receiver_user_id = $receiver_user_id;
        $assistanceTicketMessage->message = $message;
        $assistanceTicketMessage->time_sent = $time;
        $assistanceTicketMessage->created_at = date("Y-m-d H:i:s");
        $assistanceTicketMessage->save();

        $messageArray = ["message" => $message, "timeSent" => $time];

        echo json_encode($messageArray);
    }

    public function completeAssistanceTicketAction(Request $request){
        $ticket_id = $request->input("ticket_id");
        $assistanceTicket = AssistanceTicket::select("*")->where("id", $ticket_id)->first();
        $assistanceTicket->completed = 1;
        $assistanceTicket->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteAssistanceTicketAction(Request $request){
        $ticket_id = $request->input("ticket_id");
        $assistanceTicketMessages = AssistanceTicketMessage::select("*")->where("assistance_ticket_id", $ticket_id)->get();
        if(count($assistanceTicketMessages) > 0) {
            foreach ($assistanceTicketMessages as $assistanceTicketMessage) {
                $assistanceTicketMessage->delete();
            }
        }
        $assistanceTicket = AssistanceTicket::select("*")->where("id", $ticket_id)->first();
        $assistanceTicket->delete();
    }

    public function workspaceDashboard(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();

        $short_term_planner_boards_array = [];

        $short_term_planner_boards = WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $team->id)->get();
        foreach($short_term_planner_boards as $short_term_planner_board){
            array_push($short_term_planner_boards_array, $short_term_planner_board->id);
        }

        $totalTeamChatsLast24Hours = 0;
        $totalAssistanceTicketsLast24Hours = 0;
        $totalAssistanceTicketsCompletedLast24Hours = 0;

        $completedGoalsLast24Hours = 0;
        $unCompletedGoalsLast24Hours = 0;

        $totalIdeasLast24Hours = 0;
        $totalIdeasOnHoldLast24Hours = 0;
        $totalIdeasPassedLast24Hours = 0;
        $totalIdeasRejectedLast24Hours = 0;

        $totalTasksCreatedLast24Hours = 0;
        $totalTasksCompletedLast24Hours = 0;
        $totalTasksToDoLast24Hours = 0;
        $totalTasksExpiredDueDateLast24Hours = 0;



        $last24Hours = date("Y-m-d", strtotime("-1 day"));

        // chats and assistance tickets last 24 hours
        $userMessages = UserMessage::select("*")->where("team_id", $team->id)->get();
        foreach($userMessages as $userMessage){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($userMessage->created_at)))){
                $totalTeamChatsLast24Hours++;
            }
        }

        $assistanceTickets = AssistanceTicket::select("*")->where("team_id", $team->id)->get();
        foreach($assistanceTickets as $assistanceTicket){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at)))){
                $totalAssistanceTicketsLast24Hours++;
            }
        }

        $assistanceTickets = AssistanceTicket::select("*")->where("team_id", $team->id)->where("completed", 1)->get();
        foreach($assistanceTickets as $assistanceTicket){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at)))){
                $totalAssistanceTicketsCompletedLast24Hours++;
            }
        }
        // bucketlist goals last 24 hours
        $bucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team->id)->where("completed", 1)->get();
        foreach($bucketlistGoals as $bucketlistGoal){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at)))){
                $completedGoalsLast24Hours++;
            }
        }

        $bucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team->id)->where("completed", 0)->get();
        foreach($bucketlistGoals as $bucketlistGoal){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at)))){
                $unCompletedGoalsLast24Hours++;
            }
        }
        // Ideas last 24 hours
        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->get();
        foreach($ideas as $idea){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($idea->created_at)))){
                $totalIdeasLast24Hours++;
            }
        }

        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->where("status", "On hold")->get();
        foreach($ideas as $idea){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($idea->created_at)))){
                $totalIdeasOnHoldLast24Hours++;
            }
        }

        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->where("status", "Passed")->get();
        foreach($ideas as $idea){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($idea->created_at)))){
                $totalIdeasPassedLast24Hours++;
            }
        }

        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->where("status", "Rejected")->get();
        foreach($ideas as $idea){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($idea->created_at)))){
                $totalIdeasRejectedLast24Hours++;
            }
        }

        // Short term planner tasks dashboard
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($short_term_planner_task->created_at)))){
                $totalTasksCreatedLast24Hours++;
            }
        }

        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("completed", 1)->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($short_term_planner_task->created_at)))){
                $totalTasksCompletedLast24Hours++;
            }
        }

        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("completed", 0)->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($short_term_planner_task->created_at)))){
                $totalTasksToDoLast24Hours++;
            }
        }

        $today = date("Y-m-d");
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("due_date", "!=", null)->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if(strtotime($last24Hours) == strtotime(date("Y-m-d", strtotime($short_term_planner_task->created_at)))) {
                if (strtotime($today) > strtotime(date("Y-m-d", strtotime($short_term_planner_task->due_date)))) {
                    $totalTasksExpiredDueDateLast24Hours++;
                }
            }
        }

        return view("/public/team/workspace/workspaceDashboard", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
    }

    public function getRealtimeDataDashboardAction(Request $request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");

        $totalTeamChatsToday = 0;
        $totalAssistanceTicketsToday = 0;
        $totalAssistanceTicketsCompletedToday = 0;

        $totalCompletedGoalsToday = 0;
        $totalUnCompletedGoalsToday = 0;

        $totalIdeasToday = 0;
        $totalIdeasOnHoldToday = 0;
        $totalIdeasPassedToday = 0;
        $totalIdeasRejectedToday = 0;

        $last24Hours = date("Y-m-d", strtotime("-1 day"));

        $userMessages = UserMessage::select("*")->where("team_id", $team_id)->get();
        foreach($userMessages as $userMessage){
            if(strtotime(date("Y-m-d", strtotime($userMessage->created_at))) >= strtotime($last24Hours)){
                $totalTeamChatsToday++;
            }
        }

        $assistanceTickets = AssistanceTicket::select("*")->where("team_id", $team_id)->get();
        foreach($assistanceTickets as $assistanceTicket){
            if(strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) >= strtotime($last24Hours)){
                $totalAssistanceTicketsToday++;
            }
        }

        $assistanceTickets = AssistanceTicket::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
        foreach($assistanceTickets as $assistanceTicket){
            if(strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) >= strtotime($last24Hours)){
                $totalAssistanceTicketsCompletedToday++;
            }
        }

        $bucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
        foreach($bucketlistGoals as $bucketlistGoal){
            if(strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) >= strtotime($last24Hours)){
                $totalCompletedGoalsToday++;
            }
        }

        $bucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 0)->get();
        foreach($bucketlistGoals as $bucketlistGoal){
            if(strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) >= strtotime($last24Hours)){
                $totalUnCompletedGoalsToday++;
            }
        }
        // Ideas
        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team_id)->get();
        foreach($ideas as $idea){
            if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($last24Hours)){
                $totalIdeasToday++;
            }
        }

        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "On hold")->get();
        foreach($ideas as $idea){
            if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($last24Hours)){
                $totalIdeasOnHoldToday++;
            }
        }

        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Passed")->get();
        foreach($ideas as $idea){
            if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($last24Hours)){
                $totalIdeasPassedToday++;
            }
        }

        $ideas = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Rejected")->get();
        foreach($ideas as $idea){
            if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($last24Hours)){
                $totalIdeasRejectedToday++;
            }
        }

        $data = [
            "totalTeamChats" => $totalTeamChatsToday,
            "totalAssistanceTickets" => $totalAssistanceTicketsToday,
            "totalAssistanceTicketsCompleted" => $totalAssistanceTicketsCompletedToday,
            "totalCompletedGoals" => $totalCompletedGoalsToday,
            "totalUnCompletedGoals" => $totalUnCompletedGoalsToday,
            "totalIdeas" => $totalIdeasToday,
            "totalIdeasOnHold" => $totalIdeasOnHoldToday,
            "totalIdeasPassed" => $totalIdeasPassedToday,
            "totalIdeasRejected" => $totalIdeasRejectedToday,
        ];
        return json_encode($data);
    }

    public function getRealtimeDataDashboardShortTermPlannerTasksAction(Request $request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");

        $totalTasksCreatedToday = 0;
        $totalTasksCompletedToday = 0;
        $totalTasksToDoToday = 0;
        $totalTasksExpiredDueDateToday = 0;

        $last24Hours = date("Y-m-d", strtotime("-1 day"));

        $short_term_planner_boards_array = [];
        $short_term_planner_boards = WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $team_id)->get();
        foreach($short_term_planner_boards as $short_term_planner_board){
            array_push($short_term_planner_boards_array, $short_term_planner_board->id);
        }

        $shortTermPlannerTasks = WorkspaceShortTermPlannerTask::select("*")->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($shortTermPlannerTasks as $shortTermPlannerTask){
            if(strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->created_at))) >= strtotime($last24Hours)){
                $totalTasksCreatedToday++;
            }
        }

        $shortTermPlannerTasks = WorkspaceShortTermPlannerTask::select("*")->where("completed", 1)->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($shortTermPlannerTasks as $shortTermPlannerTask){
            if(strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->created_at))) >= strtotime($last24Hours)){
                $totalTasksCompletedToday++;
            }
        }

        $shortTermPlannerTasks = WorkspaceShortTermPlannerTask::select("*")->where("completed", 0)->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($shortTermPlannerTasks as $shortTermPlannerTask){
            if(strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->created_at))) >= strtotime($last24Hours)){
                $totalTasksToDoToday++;
            }
        }

        $today = date("Y-m-d");
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("due_date", "!=", null)->whereIn("short_term_planner_board_id", $short_term_planner_boards_array)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if(strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->created_at))) >= strtotime($last24Hours)) {
                if (strtotime($today) > strtotime(date("Y-m-d", strtotime($short_term_planner_task->due_date)))) {
                    $totalTasksExpiredDueDateToday++;
                }
            }
        }

        $data = [
            "totalTasksCreated" => $totalTasksCreatedToday,
            "totalTasksCompleted" => $totalTasksCompletedToday,
            "totalTasksToDo" => $totalTasksToDoToday,
            "totalTasksExpiredDueDate" => $totalTasksExpiredDueDateToday
        ];
        return json_encode($data);
    }

    public function changeMostAssistanceTicketsCategoryAction(Request $request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");
        $category = $request->input("category");


        $memberArray = [];
        $counter = 0;
        $lastMonth =  date("Y-m-d", strtotime("-1 month"));
        $lastWeek = date("Y-m-d", strtotime("-1 week"));

        if($category == "Month") {
            $timespan = $lastMonth;
        } else {
            $timespan = $lastWeek;
        }

        $assistanceTickets = AssistanceTicket::select("*")->where("team_id", $team_id)->get();
        foreach ($assistanceTickets as $assistanceTicket) {
            if (strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) > strtotime($timespan)) {
                array_push($memberArray, $assistanceTicket->creator_user_id);
            }
        }
        $count = array_count_values($memberArray);//Counts the values in the array, returns associatve array
        arsort($count); //Ssort it from highest to lowest
        $keys = array_keys($count);//Split the array so we can find the most occuring key

        $member = User::select("*")->where("id", $keys[0])->first();
        foreach ($assistanceTickets as $assistanceTicket) {
            if (strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) > strtotime($timespan)) {
                if ($assistanceTicket->creator_user_id == $member->id) {
                    $counter++;
                }
            }
        }
        $mostAssistanceTicketsArray = [
            "member" => $member->getName(),
            "tickets" => $counter,
            "category" => $category
        ];
        return json_encode($mostAssistanceTicketsArray);
    }

    public function getMemberTaskListDataAction(Request $request){
        $team_id = $request->input("team_id");
        if($request->input("toDo") == 1){

            $team = Team::select("*")->where("id", $team_id)->first();
            foreach ($team->getMembers() as $member) {
                $memberTaskData[$member->id] = $member->getAssignedTasks();
            }
            return json_encode($memberTaskData);

        } else {
            $team = Team::select("*")->where("id", $team_id)->first();
            foreach ($team->getMembers() as $member) {
                $memberTaskData[$member->id] = $member->getCompletedTasks();
            }
            return json_encode($memberTaskData);
        }
    }

    public function getDashboardFilteredDataAction(Request $request){
        $team_id = $request->input("team_id");
        $filter = $request->input("bucketlist_filter");
        if($request->input("dashboardCategory") == "Bucketlist") {
            if ($filter == "Total") {
                $totalCompletedGoals = [];
                $totalUnCompletedGoals = [];
                $bucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
                foreach ($bucketlistGoals as $bucketlistGoal) {
                    array_push($totalCompletedGoals, $bucketlistGoal);

                }

                $bucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 0)->get();
                foreach ($bucketlistGoals as $bucketlistGoal) {
                    array_push($totalUnCompletedGoals, $bucketlistGoal);
                }
                $data = [
                    "totalCompletedGoals" => count($totalCompletedGoals),
                    "totalUnCompletedGoals" => count($totalUnCompletedGoals)
                ];
                return json_encode($data);

            }
            if ($filter == "Default") {
                return 1;
            }
            if ($filter == "Month") {
                $timeSpan = date("Y-m-d", strtotime("-1 month"));
                $timeSpanLast = date("Y-m-d H:i:s", strtotime($timeSpan . "-1 month"));
            } else if ($filter == "Week") {
                $timeSpan = date("Y-m-d", strtotime("-1 week"));
                $timeSpanLast = date("Y-m-d H:i:s", strtotime($timeSpan . "-1 week"));
            }
            $totalCompletedLastTimespan = 0;
            $totalUncompletedLastTimespan = 0;
            $totalCompletedGoalsTimespanFilter = 0;
            $totalUnCompletedGoalsTimespanFilter = 0;

            $bucketlistGoalsCompletedLastTimespan = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
            foreach ($bucketlistGoalsCompletedLastTimespan as $bucketlistGoal) {
                if(strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) <= strtotime($timeSpan)) {
                    $totalCompletedLastTimespan++;
                }
            }

            $bucketlistGoalsUnCompletedLastTimespan = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 0)->get();
            foreach ($bucketlistGoalsUnCompletedLastTimespan as $bucketlistGoal) {
                if(strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) <= strtotime($timeSpan)) {
                    $totalUncompletedLastTimespan++;
                }
            }

            $bucketlistGoalsCompletedThisTimespan = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
            foreach ($bucketlistGoalsCompletedThisTimespan as $bucketlistGoal) {
                if (strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) >= strtotime($timeSpan)) {
                    $totalCompletedGoalsTimespanFilter++;
                }
            }

            $bucketlistGoalsUnCompletedThisTimespan = WorkspaceBucketlist::select("*")->where("team_id", $team_id)->where("completed", 0)->get();
            foreach ($bucketlistGoalsUnCompletedThisTimespan as $bucketlistGoal) {
                if (strtotime(date("Y-m-d", strtotime($bucketlistGoal->created_at))) >= strtotime($timeSpan)) {
                    $totalUnCompletedGoalsTimespanFilter++;
                }
            }
            $data = [
                "totalCompletedGoalsThisTimespan" => $totalCompletedGoalsTimespanFilter,
                "totalUnCompletedGoalsThisTimespan" => $totalUnCompletedGoalsTimespanFilter,
                "completedGoalsAddedValue" => $totalCompletedGoalsTimespanFilter - $totalCompletedLastTimespan,
                "unCompletedGoalsAddedValue" => $totalUnCompletedGoalsTimespanFilter - $totalUncompletedLastTimespan
            ];
            return json_encode($data);
        } else if($request->input("dashboardCategory") == "chatsAssistance") {
            if ($filter == "Total") {
                $totalTeamChats = [];
                $totalAssistanceTickets = [];
                $totalAssistanceTicketsCompleted = [];
                $teamChats = UserMessage::select("*")->where("team_id", $team_id)->get();
                foreach ($teamChats as $message) {
                    array_push($totalTeamChats, $message);
                }

                $assistanceTickets = AssistanceTicket::select("*")->where("team_id", $team_id)->get();
                foreach ($assistanceTickets as $assistanceTicket) {
                    array_push($totalAssistanceTickets, $assistanceTicket);
                }

                $assistanceTicketsCompleted = AssistanceTicket::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
                foreach ($assistanceTicketsCompleted as $assistanceTicket) {
                    array_push($totalAssistanceTicketsCompleted, $assistanceTicket);
                }
                $data = [
                    "totalTeamChats" => count($totalTeamChats),
                    "totalAssistanceTickets" => count($totalAssistanceTickets),
                    "totalAssistanceTicketsCompleted" => count($totalAssistanceTicketsCompleted)
                ];
                return json_encode($data);

            }
            if ($filter == "Default") {
                return 1;
            }
            if ($filter == "Month") {
                $timeSpan = date("Y-m-d", strtotime("-1 month"));
                $timeSpanLast = date("Y-m-d H:i:s", strtotime($timeSpan . "-1 month"));
            } else if ($filter == "Week") {
                $timeSpan = date("Y-m-d", strtotime("-1 week"));
                $timeSpanLast = date("Y-m-d H:i:s", strtotime($timeSpan . "-1 week"));
            }
            $totalTeamChatsLastTimespan = 0;
            $totalAssistanceTicketsLastTimespan = 0;
            $totalAssistanceTicketsCompletedLastTimespan = 0;
            $totalTeamChatsTimespanFilter = 0;
            $totalAssistanceTicketsTimespanFilter = 0;
            $totalAssistanceTicketsCompletedTimespanFilter = 0;

            $teamChatsLastTimespan = UserMessage::select("*")->where("team_id", $team_id)->get();
            foreach ($teamChatsLastTimespan as $message) {
                if(strtotime(date("Y-m-d", strtotime($message->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($message->created_at))) <= strtotime($timeSpan)) {
                    $totalTeamChatsLastTimespan++;
                }
            }

            $assistanceTicketsLastTimespan = AssistanceTicket::select("*")->where("team_id", $team_id)->get();
            foreach ($assistanceTicketsLastTimespan as $assistanceTicket) {
                if(strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) <= strtotime($timeSpan)) {
                    $totalAssistanceTicketsLastTimespan++;
                }
            }

            $assistanceTicketsCompletedLastTimespan = AssistanceTicket::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
            foreach ($assistanceTicketsCompletedLastTimespan as $assistanceTicket) {
                if(strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) <= strtotime($timeSpan)) {
                    $totalAssistanceTicketsCompletedLastTimespan++;
                }
            }

            $teamChatsThisTimespan = UserMessage::select("*")->where("team_id", $team_id)->get();
            foreach ($teamChatsThisTimespan as $message) {
                if (strtotime(date("Y-m-d", strtotime($message->created_at))) >= strtotime($timeSpan)) {
                    $totalTeamChatsTimespanFilter++;
                }
            }

            $assistanceTicketsThisTimespan = AssistanceTicket::select("*")->where("team_id", $team_id)->get();
            foreach ($assistanceTicketsThisTimespan as $assistanceTicket) {
                if (strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) >= strtotime($timeSpan)) {
                    $totalAssistanceTicketsTimespanFilter++;
                }
            }

            $assistanceTicketsCompletedThisTimespan = AssistanceTicket::select("*")->where("team_id", $team_id)->where("completed", 1)->get();
            foreach ($assistanceTicketsCompletedThisTimespan as $assistanceTicket) {
                if (strtotime(date("Y-m-d", strtotime($assistanceTicket->created_at))) >= strtotime($timeSpan)) {
                    $totalAssistanceTicketsCompletedTimespanFilter++;
                }
            }
            $data = [
                "totalTeamChatsThisTimespan" => $totalTeamChatsTimespanFilter,
                "totalAssistanceTicketsThisTimespan" => $totalAssistanceTicketsTimespanFilter,
                "totalAssistanceTicketsCompletedThisTimespan" => $totalAssistanceTicketsCompletedTimespanFilter,
                "teamChatsAddedValue" => $totalTeamChatsTimespanFilter - $totalTeamChatsLastTimespan,
                "assistanceTicketsAddedValue" => $totalAssistanceTicketsTimespanFilter - $totalAssistanceTicketsLastTimespan,
                "assistanceTicketsCompletedAddedValue" => $totalAssistanceTicketsCompletedTimespanFilter - $totalAssistanceTicketsCompletedLastTimespan
            ];
            return json_encode($data);
        } else if($request->input("dashboardCategory") == "Ideas") {
            if ($filter == "Total") {

                $totalIdeas = WorkspaceIdeas::select("*")->where("team_id", $team_id)->get();
                $totalIdeasOnHold = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "On hold")->get();
                $totalIdeasPassed = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Passed")->get();
                $totalIdeasRejected = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status","Rejected")->get();

                $data = [
                    "totalIdeas" => count($totalIdeas),
                    "totalIdeasOnHold" => count($totalIdeasOnHold),
                    "totalIdeasPassed" => count($totalIdeasPassed),
                    "totalIdeasRejected" => count($totalIdeasRejected)
                ];
                return json_encode($data);

            }
            if ($filter == "Default") {
                return 1;
            }
            if ($filter == "Month") {
                $timeSpan = date("Y-m-d", strtotime("-1 month"));
                $timeSpanLast = date("Y-m-d H:i:s", strtotime($timeSpan . "-1 month"));
            } else if ($filter == "Week") {
                $timeSpan = date("Y-m-d", strtotime("-1 week"));
                $timeSpanLast = date("Y-m-d H:i:s", strtotime($timeSpan . "-1 week"));
            }
            $totalIdeasLastTimespan = 0;
            $totalIdeasOnHoldLastTimespan = 0;
            $totalIdeasPassedLastTimespan = 0;
            $totalIdeasRejectedLastTimespan = 0;

            $totalIdeasTimespanFilter = 0;
            $totalIdeasOnHoldTimespanFilter = 0;
            $totalIdeasPassedTimespanFilter = 0;
            $totalIdeasRejectedTimespanFilter = 0;

            $ideasLastTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->get();
            foreach ($ideasLastTimespan as $idea) {
                if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($idea->created_at))) <= strtotime($timeSpan)) {
                    $totalIdeasLastTimespan++;
                }
            }

            $ideasOnHoldLastTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "On hold")->get();
            foreach ($ideasOnHoldLastTimespan as $idea) {
                if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($idea->created_at))) <= strtotime($timeSpan)) {
                    $totalIdeasOnHoldLastTimespan++;
                }
            }

            $ideasPassedLastTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Passed")->get();
            foreach ($ideasPassedLastTimespan as $idea) {
                if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($idea->created_at))) <= strtotime($timeSpan)) {
                    $totalIdeasPassedLastTimespan++;
                }
            }

            $ideasRejectedLastTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Rejected")->get();
            foreach ($ideasRejectedLastTimespan as $idea) {
                if(strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpanLast) && strtotime(date("Y-m-d", strtotime($idea->created_at))) <= strtotime($timeSpan)) {
                    $totalIdeasRejectedLastTimespan++;
                }
            }

            // This timespan
            $ideasThisTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->get();
            foreach ($ideasThisTimespan as $idea) {
                if (strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpan)) {
                    $totalIdeasTimespanFilter++;
                }
            }

            $ideasOnHoldThisTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "On hold")->get();
            foreach ($ideasOnHoldThisTimespan as $idea) {
                if (strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpan)) {
                    $totalIdeasOnHoldTimespanFilter++;
                }
            }

            $ideasPassedThisTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Passed")->get();
            foreach ($ideasPassedThisTimespan as $idea) {
                if (strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpan)) {
                    $totalIdeasPassedTimespanFilter++;
                }
            }

            $ideasRejectedThisTimespan = WorkspaceIdeas::select("*")->where("team_id", $team_id)->where("status", "Rejected")->get();
            foreach ($ideasRejectedThisTimespan as $idea) {
                if (strtotime(date("Y-m-d", strtotime($idea->created_at))) >= strtotime($timeSpan)) {
                    $totalIdeasRejectedTimespanFilter++;
                }
            }
            $data = [
                "totalIdeasThisTimespan" => $totalIdeasTimespanFilter,
                "totalIdeasOnHoldThisTimespan" => $totalIdeasOnHoldTimespanFilter,
                "totalIdeasPassedThisTimespan" => $totalIdeasPassedTimespanFilter,
                "totalIdeasRejectedThisTimespan" => $totalIdeasRejectedTimespanFilter,

                "ideasAddedValue" => $totalIdeasTimespanFilter - $totalIdeasLastTimespan,
                "ideasOnHoldAddedValue" => $totalIdeasOnHoldTimespanFilter - $totalIdeasOnHoldLastTimespan,
                "ideasPassedAddedValue" => $totalIdeasPassedTimespanFilter - $totalIdeasPassedLastTimespan,
                "ideasRejectedAddedValue" => $totalIdeasRejectedTimespanFilter - $totalIdeasRejectedLastTimespan
            ];
            return json_encode($data);
        }
    }



}
