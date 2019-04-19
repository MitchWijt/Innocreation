<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/04/2019
 * Time: 17:52
 */

namespace App\Services\TeamProject;

use App\TeamProject;
use Illuminate\Support\Facades\Session;

class TeamProjectService {
    public function index(){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        // gets the "success" index from the returned json array from the API to get a normal array of data
        if(self::getErrorResponse($teamProjectApi->getProjects($userId))){
            return self::getErrorResponse($teamProjectApi->getProjects($userId));
        }

        $projects = self::getSuccessResponse($teamProjectApi->getProjects($userId));
        return view("/public/teamProjects/index", compact("projects"));
    }



    public function teamProjectPlannerIndex($slug){
        $teamProject = TeamProject::select("*")->where("slug", $slug)->first();
        $pageType = "planner";
        return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType"));
    }


    private static function getSuccessResponse($response){
        return $response->success;
    }

    private static function getErrorResponse($response){
        if(isset($response->error)){
            return $response->error;
        } else {
            return false;
        }
    }
}