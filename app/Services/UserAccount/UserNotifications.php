<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 29/10/2018
 * Time: 21:13
 */
namespace App\Services\UserAccount;
use App\Expertises;
use App\Expertises_linktable;
use App\Favorite_expertises_linktable;
use GetStream;
use Illuminate\Support\Facades\Session;

class UserNotifications
{
    public function getStreamDataFromUser($userId){
        $client = new GetStream\Stream\Client(env("STREAM_API"), env("STREAM_SECRET"));
        $messageFeed = $client->feed('user', $userId);
        return $this->returnViewWithData($messageFeed->getActivities(0,20)['results']);
    }

    public function returnViewWithData($notifications){
        return view("/public/shared/_popoverNotificationsData", compact('notifications'));
    }
}