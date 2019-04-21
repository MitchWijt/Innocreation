<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/04/2019
 * Time: 17:56
 */

namespace App\Services\TeamProject;


use App\User;

class TeamProjectApi {

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