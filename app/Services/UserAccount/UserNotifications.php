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
use App\UserChat;
use GetStream;
use Illuminate\Support\Facades\Session;
use App\Services\FeedServices\SwitchUserWork as SwitchUserWork;

class UserNotifications
{
    public function getStreamDataFromUser($userId, $switchUserWork){
        $client = new GetStream\Stream\Client(env("STREAM_API"), env("STREAM_SECRET"));
        $messageFeed = $client->feed('user', $userId);
        return $this->returnViewWithData($messageFeed->getActivities(0,20)['results'], $userId, $switchUserWork);
    }

    public function returnViewWithData($notifications, $userId, $switchUserWork){
        $connections = $switchUserWork->listConnectionRequests($userId);
        return view("/public/shared/_popoverNotificationsData", compact('notifications', 'connections'));
    }

    public function getRecentUserchats($userId){
        $userChats = UserChatsService::getRecentChats($userId);
        return view("/public/shared/messagesHeaderBox/_popoverData", compact("userChats", "userId"));
    }

    public function toChat($userChatId){
        Session::set("userChatId", $userChatId);
        return redirect("/my-account/chats");
    }
}