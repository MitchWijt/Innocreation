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
    public function getProjects($userId){
        $sessionData = self::openSession($userId);
        $post = [
            'user_id' => $sessionData['uid']
        ];
        $ch = curl_init('https://api.innocreation.net/api/getProjects');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        //Set your auth headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $sessionData['token'],
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);

    }

    private function openSession($userId){
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