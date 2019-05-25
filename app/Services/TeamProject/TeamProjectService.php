<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/04/2019
 * Time: 17:52
 */

namespace App\Services\TeamProject;

use App\Team;
use App\TeamProject;
use App\TeamProjectFolder;
use App\TeamProjectTask;
use App\User;
use function GuzzleHttp\json_encode;
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

    public function getTaskData($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        // gets the "success" index from the returned json array from the API to get a normal array of data
        if(self::getErrorResponse($teamProjectApi->getTaskData($userId, $request))){
            return self::getErrorResponse($teamProjectApi->getTaskData($userId, $request));
        }

        $taskData = self::getSuccessResponse($teamProjectApi->getTaskData($userId, $request));
        $team = Team::select("*")->where("id", $taskData->team_id)->first();
        return view("/public/teamProjects/shared/_taskData", compact("taskData", "team"));
    }

    public function openRecentTask(){
        if(Session::has("recent_task_id")) {

            $task_id = Session::get("recent_task_id");
            $task = TeamProjectTask::select("*")->where("id", $task_id)->first();
            $folderId = $task->team_project_folder_id;
            $array = [
                'task_id' => $task_id,
                'folder_id' => $folderId
            ];
            return json_encode($array);
        }
    }

    public function setRecentTask($request){
        Session::remove("recent_task_id");
        sleep(1);
        Session::set("recent_task_id", $request->input("task_id"));

        //gets task and sets a selected folder id.
        $task = TeamProjectTask::select("*")->where("id", $request->input("task_id"))->first();
        $folderId = $task->team_project_folder_id;
        Session::set("folder_id", $folderId);

        $id = Session::get("recent_task_id");
        return $folderId;
    }


    public function updateTaskContent($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        // gets the "success" index from the returned json array from the API to get a normal array of data
        if(self::getErrorResponse($teamProjectApi->updateTaskContent($userId, $request))){
            return self::getErrorResponse($teamProjectApi->updateTaskContent($userId, $request));
        }

        return self::getSuccessResponse($teamProjectApi->updateTaskContent($userId, $request));
    }

    public function assignUserToTask($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        if(self::getErrorResponse($teamProjectApi->assignUserToTask($userId, $request))){
            return self::getErrorResponse($teamProjectApi->assignUserToTask($userId, $request));
        }

        $returnData = self::getSuccessResponse($teamProjectApi->assignUserToTask($userId, $request));
        $user = User::select("*")->where("id", $returnData)->first();
        $dataArray = [
            'profilePicture' => $user->getProfilePicture(),
            'name' => $user->getName()
        ];
        return json_encode($dataArray);
    }


    public function teamProjectPlannerIndex($slug){
        $teamProject = TeamProject::select("*")->where("slug", $slug)->first();
        $pageType = "planner";
        return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType"));
    }

    public function editLabelsTask($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        // gets the "success" index from the returned json array from the API to get a normal array of data
        if(self::getErrorResponse($teamProjectApi->editLabelsTask($userId, $request))){
            return self::getErrorResponse($teamProjectApi->editLabelsTask($userId, $request));
        }

        return self::getSuccessResponse($teamProjectApi->editLabelsTask($userId, $request));
    }

    public function addDueDate($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        // gets the "success" index from the returned json array from the API to get a normal array of data
        if(self::getErrorResponse($teamProjectApi->addDueDate($userId, $request))){
            return self::getErrorResponse($teamProjectApi->addDueDate($userId, $request));
        }

        $results = self::getSuccessResponse($teamProjectApi->addDueDate($userId, $request));

        return json_encode($results);
    }

    public function addFolderToProject($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

//        if(self::getErrorResponse($teamProjectApi->addFolderToProject($userId, $request))){
//            return self::getErrorResponse($teamProjectApi->addFolderToProject($userId, $request));
//        }

        return self::getSuccessResponse($teamProjectApi->addFolderToProject($userId, $request));
    }

    public function getTasksOfFolder($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        if(self::getErrorResponse($teamProjectApi->getTasksOfFolder($userId, $request))){
            return self::getErrorResponse($teamProjectApi->getTasksOfFolder($userId, $request));
        }

        $data = self::getSuccessResponse($teamProjectApi->getTasksOfFolder($userId, $request));
        $tasks = $data->tasks;
        $folderId = $data->folderId;
        return view("/public/teamProjects/shared/_taskCollapse", compact("tasks", "folderId"));

    }

    public function addTask($request){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

//        if(self::getErrorResponse($teamProjectApi->addTask($userId))){
//            return self::getErrorResponse($teamProjectApi->addTask($userId));
//        }

         if(!Session::has("folder_id")){
            $projectId = $request->input("teamProjectId");
            $myTasksFolder = TeamProjectFolder::select("*")->where("team_project_id", $projectId)->where("title", "My tasks")->first();
            Session::set("folder_id", $myTasksFolder->id);
         }
        $data = self::getSuccessResponse($teamProjectApi->addTask($userId));
        $taskId = $data->task_id;
        $folderId = Session::get("folder_id");
        $tasks = TeamProjectTask::select("*")->where("team_project_folder_id", $folderId)->get();

        $view = view("/public/teamProjects/shared/_taskCollapse", compact("tasks", "folderId"));
        $viewData = $view->render();
        $dataArray = ['taskId' => $taskId, "view" => $viewData, 'folderId' => $folderId];
        return json_encode($dataArray);



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