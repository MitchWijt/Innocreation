<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\WorkspaceBucketlist;
use App\WorkspaceBucketlistType;
use App\WorkspaceIdeas;
use App\WorkspaceShortTermPlannerBoard;
use App\WorkspaceShortTermPlannerTask;
use App\WorkspaceShortTermPlannerType;
use Illuminate\Http\Request;
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
        $shortTermPlannerBoard = WorkspaceShortTermPlannerBoard::select("*")->where("id", $id)->first();
        $allShortTermPlannerBoards = WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $team->id)->get();
        $shortTermPlannerTasks = WorkspaceShortTermPlannerTask::select("*")->where("short_term_planner_board_id", $shortTermPlannerBoard->id)->orderBy("priority", "DESC")->get();
        $uncompletedBucketlistGoals = WorkspaceBucketlist::select("*")->where("team_id", $team->id)->where("completed", 0)->where("used_on_short_term_planner", 0)->get();
        $passedIdeas = WorkspaceIdeas::select("*")->where("team_id", $team->id)->where("status", "Passed")->where("used_on_short_term_planner", 0)->get();
        return view("/public/team/workspace/workspaceShortTermPlannerBoard", compact("team", "user", "shortTermPlannerBoard", "shortTermPlannerTasks", "uncompletedBucketlistGoals", "passedIdeas","allShortTermPlannerBoards"));
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

        $toDoTasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $user->id)->where("completed", 0)->get();
        $completedTasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $user->id)->where("completed", 1)->get();
        $shortTermPlannerTasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $user->id)->where("due_date", "!=", null)->get();

        foreach($shortTermPlannerTasks as $shortTermPlannerTask){
            if(strtotime($today) > strtotime(date("Y-m-d", strtotime($shortTermPlannerTask->due_date)))){
                array_push($missedDueDateTasks, $shortTermPlannerTask);
            }
        }



        return view("/public/team/workspace/workspacePersonalBoard", compact("user", "team", "toDoTasks", "completedTasks", "missedDueDateTasks"));
    }
}
