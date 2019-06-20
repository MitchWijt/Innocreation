<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/04/2019
 * Time: 17:56
 */

namespace App\Services\TeamProject;


use App\TeamProjectTaskType;
use App\User;
use Illuminate\Support\Facades\Session;

class TeamProjectApi {

    public function validateUser($userId){
        $sessionData = self::openSession($userId);
        $post = [
            'user_id' => $sessionData['uid']
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/validateUser', $post, $sessionData['token']);
        return json_decode($result);
    }

    // sends the appropiate data to the curl call and returns data in json format
    public function getProjects($userId){
        $sessionData = self::openSession($userId);
        $post = [
            'user_id' => $sessionData['uid']
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/getProjects', $post, $sessionData['token']);
        return json_decode($result);
    }

    // sends the appropiate data to the curl call and returns data in json format
    public function getFoldersAndTasks($userId, $request){
        $sessionData = self::openSession($userId);
        $post = [
            'user_id' => $sessionData['uid'],
            'team_project_id' => $request->input("team_project_id")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/getFoldersAndTasks', $post, $sessionData['token']);
        return json_decode($result);
    }

    public function getTaskData($userId, $request){
        $sessionData = self::openSession($userId);
        $post = [
            'user_id' => $sessionData['uid'],
            'task_id' => $request->input("task_id")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/getTaskData', $post, $sessionData['token']);
        return json_decode($result);
    }

    public function updateTaskContent($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'task_id' => $request->input("task_id"),
            'content' => $request->input("contentHtml"),
            'category' => $request->input("category")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/updateTaskContent', $post, $user->api_token);
        return json_decode($result);
    }

    public function assignUserToTask($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'memberId' => $request->input("memberId"),
            "taskId" => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/assignUserToTask', $post, $user->api_token);
        return json_decode($result);

    }

    public function editLabelsTask($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'tokens' => $request->input("tokens"),
            "taskId" => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/editLabelsTask', $post, $user->api_token);
        return json_decode($result);
    }

    public function addDueDate($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'date' => $request->input("date"),
            "taskId" => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/addDueDate', $post, $user->api_token);
        return json_decode($result);
    }

    public function addFolderToProject($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'folderName' => $request->input("folderName"),
            "teamProjectId" => $request->input("teamProjectId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/addFolderToProject', $post, $user->api_token);
        return json_decode($result);
    }

    public function getTasksOfFolder($userId, $folderId){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'folderId' => $folderId,
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/getTasksOfFolder', $post, $user->api_token);
        return json_decode($result);
    }

    public function addTask($userId, $request, $folderId){
        $type = TeamProjectTaskType::select("*")->where("title", ucfirst($request->input("type")))->first();
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'folderId' => $folderId,
            'type' => $type->id
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/addTask', $post, $user->api_token);
        return json_decode($result);

    }

    public function changeFolderOfTask($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'currentFolderId' => $request->input("currentFolder"),
            'newFolderId' => $request->input('newFolder'),
            'taskId' => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/changeFolderOfTask', $post, $user->api_token);
        return json_decode($result);

    }

    public function addProject($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'projectTitle' => $request->input("projectTitle")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/addProject', $post, $user->api_token);
        return json_decode($result);
    }

    public function setTaskPrivate($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'taskId' => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/setTaskPrivate', $post, $user->api_token);
        return json_decode($result);
    }

    public function setTaskPublic($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'taskId' => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/setTaskPublic', $post, $user->api_token);
        return json_decode($result);
    }

    public function addTaskToValidationProcess($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'taskId' => $request->input("taskId")
        ];
        $result = self::sendRequestAndReturnData('https://api.innocreation.net/api/addTaskToValidationProcess', $post, $user->api_token);
        return json_decode($result);
    }

    public function saveImprovementTasks($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'taskId' => $request->input("task_id"),
            "improvementPoints" => $request->input("improvement_points")
        ];
        self::sendRequestAndReturnData('https://api.innocreation.net/api/saveImprovementTasks', $post, $user->api_token);
        return "TRUE";
    }

    public function savePassedTask($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'taskId' => $request->input("task_id")
        ];
        self::sendRequestAndReturnData('https://api.innocreation.net/api/savePassedTask', $post, $user->api_token);
        return "TRUE";
    }

    public function triggerImprovementPoint($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'validationId' => $request->input("id"),
            'checked' => $request->input("checked")
        ];
        self::sendRequestAndReturnData('https://api.innocreation.net/api/triggerImprovementPoint', $post, $user->api_token);
        return "TRUE";
    }

    public function allImprovementPointsChecked($userId, $request){
        $user = User::select("*")->where("id", $userId)->first();
        $post = [
            'user_id' => $userId,
            'task_id' => $request->input("task_id"),
        ];
        $res = self::sendRequestAndReturnData('https://api.innocreation.net/api/allImprovementPointsChecked', $post, $user->api_token);
        return json_decode($res);
    }




    // Gets the PostFIELDS, curl_url and api_token from parameters, sends Curl request to the API domain and returns data.
    public static function sendRequestAndReturnData($url, $postFields, $token){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ));

        $result = curl_exec($ch);
//        dd($result);
        curl_close($ch);

        return $result;
    }



    /**
     * Opens a new session for the API
     * Returns a token and user_id of the user connecting to the API
     *
     */
    private static function openSession($userId){
        $user = User::select("*")->where("id", $userId)->first();

        $post = [
            'user_id' => $user->id,
        ];
        $token = $user->api_token;
        $ch = curl_init('https://api.innocreation.net/api/openSession');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ));
        $result = curl_exec($ch);
        $resultSession = json_decode($result);
        curl_close($ch);

        return ['token' => $resultSession->success->token, 'uid' => $resultSession->success->user->id];
    }
}