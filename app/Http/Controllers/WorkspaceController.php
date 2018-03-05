<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
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
        return view("/public/team/workplace/workplaceIntroduction", compact("team"));
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
        return view("/public/team/workplace/workplaceIdeas", compact("team" , "user","workplaceIdeas"));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
