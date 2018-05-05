<?php

namespace App\Http\Controllers;

use App\Country;
use App\Expertises_linktable;
use App\ForumThread;
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\NeededExpertiseLinktable;
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
            return view("/admin/statistics", compact("user", "totalUsers", "totalInvited" , "totalMessages", "totalRequests", "totalTasks", "totalTeams"));
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
            $admin = User::select("*")->where("id", Session::get("user_id"))->first();
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
            $team = Team::select("*")->where("id", $id)->first();
            return view("/admin/teamEditor", compact("team"));
        }
    }
}
