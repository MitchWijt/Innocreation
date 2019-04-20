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

    // sends a request to the API service and returns the API data which are folders and tasks of the project in json format.
    public function getFoldersAndTasksView($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        // gets the "success" index from the returned json array from the API to get a normal array of data
        if(self::getErrorResponse($teamProjectApi->getFoldersAndTasks($userId, $request))){
            return self::getErrorResponse($teamProjectApi->getFoldersAndTasks($userId, $request));
        }

        $foldersAndTasks = self::getSuccessResponse($teamProjectApi->getFoldersAndTasks($userId, $request));
        return view('/public/teamProjects/shared/_foldersAndTasks', compact("foldersAndTasks"));
    }



    public function teamProjectPlannerIndex($slug){
        $teamProject = TeamProject::select("*")->where("slug", $slug)->first();
        $pageType = "planner";
        return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType"));
    }


    // Gets the success data from the json reponse from the API
    private static function getSuccessResponse($response){
        return $response->success;
    }

    // Gets the error data if there is a error from the json response API.
    private static function getErrorResponse($response){
        if(isset($response->error)){
            return $response->error;
        } else {
            return false;
        }
    }
}