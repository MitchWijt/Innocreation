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
        return view("/public/teamProjects/index", compact("projects"));
    }

    public function getProjects(){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        $data = self::getSuccessResponse($teamProjectApi->getProjects($userId));
        $projects = $data->projects;
        return view("/public/teamProjects/shared/_teamProjects", compact("projects"));
    }

    // sends a request to the API service and returns the API data which are folders and tasks of the project in json format.
    public function getFoldersAndTasksView($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        $foldersAndTasks = self::getSuccessResponse($teamProjectApi->getFoldersAndTasks($userId, $request));
        return view('/public/teamProjects/shared/_foldersAndTasks', compact("foldersAndTasks"));
    }

    public function getTaskData($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();


        $taskData = self::getSuccessResponse($teamProjectApi->getTaskData($userId, $request));
        $team = Team::select("*")->where("id", $taskData->team_id)->first();
        $teamProject = TeamProject::select("*")->where("id", $request->input("team_project_id"))->first();
        $allLabels = $teamProject->getAllLabels();
        return view("/public/teamProjects/shared/_taskData", compact("taskData", "team", "allLabels", "teamProject"));
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

        $id = Session::get("recent_task_id");
        return $id;
    }

    public function setRecentFolder($request){
        //gets task and sets a selected folder id.
        $folder = TeamProjectFolder::select("*")->where("id", $request->input("folder_id"))->first();
        Session::set("folder_id", $folder->id);

        return Session::get("folder_id");
    }

    public function removeRecentFolderSession(){
        Session::remove("folder_id");
        return "TRUE";
    }


    public function updateTaskContent($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        return self::getSuccessResponse($teamProjectApi->updateTaskContent($userId, $request));
    }

    public function assignUserToTask($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        $returnData = self::getSuccessResponse($teamProjectApi->assignUserToTask($userId, $request));
        $user = User::select("*")->where("id", $returnData)->first();
        $dataArray = [
            'profilePicture' => $user->getProfilePicture(),
            'name' => $user->getName()
        ];
        return json_encode($dataArray);
    }


    public function teamProjectPlannerIndex($slug){
        if(self::checkForError()){
            return self::checkForError();
        }

        $teamProject = TeamProject::select("*")->where("slug", $slug)->first();
        $pageType = "planner";
        return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType"));
    }

    public function editLabelsTask($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        return self::getSuccessResponse($teamProjectApi->editLabelsTask($userId, $request));
    }

    public function addDueDate($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        $results = self::getSuccessResponse($teamProjectApi->addDueDate($userId, $request));

        return json_encode($results);
    }

    public function addFolderToProject($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        return self::getSuccessResponse($teamProjectApi->addFolderToProject($userId, $request));
    }

    public function getTasksOfFolder($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        $data = self::getSuccessResponse($teamProjectApi->getTasksOfFolder($userId, $request));
        $tasks = $data->tasks;
        $folderId = $data->folderId;
        return view("/public/teamProjects/shared/_taskCollapse", compact("tasks", "folderId"));

    }

    public function addTask($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

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

    public function changeFolderOfTask($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        $data = self::getSuccessResponse($teamProjectApi->changeFolderOfTask($userId, $request));

        $folderId = $data->oldFolderId;
        $oldFolderviewData = self::getTasksForFolderReturnView($folderId);

        $folderId = $data->newFolderId;
        $newFolderviewData = self::getTasksForFolderReturnView($folderId);

        $dataArray = ['oldFolderId' => $data->oldFolderId, "newFolderId" => $data->newFolderId, "oldView" => $oldFolderviewData, "newView" => $newFolderviewData, 'newFolderName' => $data->newFolderName];
        return json_encode($dataArray);
    }

    public function addProject($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        $projects = self::getSuccessResponse($teamProjectApi->addProject($userId, $request));
        return view("/public/teamProjects/shared/_teamProjects", compact("projects"));
    }

    // static funnction to retreve tasks from folder in paramters and return a rendered view with the collapse of the tasks.
    public static function getTasksForFolderReturnView($folderId){
        $tasks = TeamProjectTask::select("*")->where("team_project_folder_id", $folderId)->get();
        $view = view("/public/teamProjects/shared/_taskCollapse", compact("tasks", "folderId"));
        $viewData = $view->render();

        return $viewData;
    }

    private static function checkForError(){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        if(self::getErrorResponse($teamProjectApi->validateUser($userId))){
            return self::getErrorResponse($teamProjectApi->validateUser($userId));
            die();
        }
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