<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/04/2019
 * Time: 17:52
 */

namespace App\Services\TeamProject;

use App\Services\Encrypter;
use App\Team;
use App\TeamProject;
use App\TeamProjectFolder;
use App\TeamProjectLinktable;
use App\TeamProjectTask;
use App\User;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;

class TeamProjectService {
    public function index(){
        return view("/public/teamProjects/index", compact("pageType"));
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

    public function getTaskContextMenu($request){
        $taskId = $request->input("taskId");
        $task = TeamProjectTask::select("*")->where("id", $taskId)->first();
        return view("public/teamProjects/shared/_taskContextMenu", compact("task"));
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
        //Get the clicked taskId and enrypts it to a hash together with the folderId hash and returns it to the success of the ajax function.
        $task = TeamProjectTask::select("*")->where("id", $request->input("task_id"))->first();
        $teamProject = $task->folder->teamProject;
        $taskHash = Encrypter::encrypt_decrypt("encrypt", $request->input("task_id"));
        $folderHash = Encrypter::encrypt_decrypt("encrypt", $task->team_project_folder_id);
        $data = ["teamProjectSlug" => $teamProject->slug, "taskHash" => $taskHash, "folderHash" => $folderHash];
        return json_encode($data);
    }

    public function setRecentFolder($request){
        //gets task and sets a selected folder id.
        $folder = TeamProjectFolder::select("*")->where("id", $request->input("folder_id"))->first();
        $folderHash = Encrypter::encrypt_decrypt("encrypt", $folder->id);
        $teamProject = $folder->teamProject;
        $data = ['teamProjectSlug' => $teamProject->slug, "folderHash" => $folderHash];
        return json_encode($data);
    }

    public function removeRecentFolderSession($request){
        $folderId = $request->input("folderId");
        $folder = TeamProjectFolder::select("*")->where("id", $folderId)->first();
        $teamProject = $folder->teamProject;
        if(isset($folderId)){
            return json_encode(['teamProjectSlug' => $teamProject->slug]);
        }
    }


    public function updateTaskContent($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        self::getSuccessResponse($teamProjectApi->updateTaskContent($userId, $request));

        $task = TeamProjectTask::select("*")->where("id", $request->input("task_id"))->first();
        $view = self::getTasksForFolderReturnView($task->folder->id);
        $folderId = $task->folder->id;

        return json_encode(['folderId' => $folderId, "view" => $view]);
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


    public function teamProjectPlannerIndex($slug, $request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $teamProject = TeamProject::select("*")->where("slug", $slug)->first();
        $pageType = "planner";

        // Checks if logged in user with team has access to enter this project. else it will return a forbidden page.
        if(self::validProjectWithTeam($teamProject->id)) {
            $taskHash = $request->get("th");
            $folderHash = $request->get("fh");
            // checks if there is a recentFolder hash or recentTaskHash in the url GET parameters. If its the case it will decrypt the hash to an id and send them as a variable to the view.
            if (isset($taskHash) && isset($folderHash)) {
                $activeTaskId = Encrypter::encrypt_decrypt("decrypt", $taskHash);
                $activeFolderId = Encrypter::encrypt_decrypt("decrypt", $folderHash);

                return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType", "activeTaskId", "activeFolderId"));
            } else if (isset($folderHash)) {
                $activeFolderId = Encrypter::encrypt_decrypt("decrypt", $folderHash);

                return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType", "activeFolderId"));
            } else {
                return view("/public/teamProjects/teamProjectPlanner", compact("teamProject", "pageType"));
            }
        } else {
            return abort(403);
        }
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
        $folderId = $request->input("folderId");
         if(!isset($folderId)){
            $projectId = $request->input("teamProjectId");
            $myTasksFolder = TeamProjectFolder::select("*")->where("team_project_id", $projectId)->where("title", "My tasks")->first();
            $folderId = $myTasksFolder->id;
         } else {
             $folderId = $request->input("folderId");
         }
        $data = self::getSuccessResponse($teamProjectApi->addTask($userId, $request, $folderId));
        $taskId = $data->task_id;
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

    public function setTaskPrivate($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        $data = self::getSuccessResponse($teamProjectApi->setTaskPrivate($userId, $request));
        $view = self::getTasksForFolderReturnView($data->folder_id);

        return json_encode(['view' => $view, "folderId" => $data->folder_id]);


    }

    public function setTaskPublic($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        $data = self::getSuccessResponse($teamProjectApi->setTaskPublic($userId, $request));
        $view = self::getTasksForFolderReturnView($data->folder_id);

        return json_encode(['view' => $view, "folderId" => $data->folder_id]);
    }

    public function addTaskToValidationProcess($request){
        if(self::checkForError()){
            return self::checkForError();
        }

        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();

        $data = self::getSuccessResponse($teamProjectApi->addTaskToValidationProcess($userId, $request));
        $folderId = $data->folder_id;
        $oldFolderId = $data->old_folder_id;
        $oldFolderView = self::getTasksForFolderReturnView($oldFolderId);
        $view = self::getTasksForFolderReturnView($folderId);

        return json_encode(['folderId' => $folderId, "view" => $view, "oldFolderId" => $oldFolderId, "oldFolderView" => $oldFolderView]);
    }

    // static funnction to retreve tasks from folder in paramters and return a rendered view with the collapse of the tasks.
    public static function getTasksForFolderReturnView($folderId){
        $folder = TeamProjectFolder::select("*")->where("id", $folderId)->first();
        $tasks = $folder->getAllTasks(Session::get("user_id"));
        $view = view("/public/teamProjects/shared/_taskCollapse", compact("tasks", "folderId"));
        $viewData = $view->render();

        return $viewData;
    }

    private static function validProjectWithTeam($projectId){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $teamProjectLinktable = TeamProjectLinktable::select("*")->where("team_id", $user->team_id)->where("team_project_id", $projectId)->first();
        if($teamProjectLinktable){
            return true;
        } else {
            return false;
        }
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