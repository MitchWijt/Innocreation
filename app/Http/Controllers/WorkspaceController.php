<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\WorkspaceBucketlist;
use App\WorkspaceBucketlistType;
use App\WorkspaceIdeas;
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
        $bucketlistType->delete();
    }

    public function renameBucketlistBoardAction(Request $request){
        $bucketlist_type_id = $request->input("bucketlist_type_id");
        $new_title = $request->input("new_title");

        $bucketlistType = WorkspaceBucketlistType::select("*")->where("id", $bucketlist_type_id)->first();
        $bucketlistType->name = $new_title;
        $bucketlistType->save();
    }
}
