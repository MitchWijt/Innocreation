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
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\UserChat;
use GetStream;
use Illuminate\Support\Facades\Session;
use App\Services\FeedServices\SwitchUserWork as SwitchUserWork;
use App\Services\AppServices\StreamService as StreamService;

class UserNotifications
{
    public function getStreamDataFromUser($userId, $switchUserWork, $streamService){
        $messageFeed = $streamService->getStreamFeed($userId);
        $results = $messageFeed->getActivities(0,100)['results'];
        $notifications = [];
        foreach($results as $result) {
            if (isset($result['category']) && $result['category'] == "notification") {
                array_push($notifications, $result);
            }
        }
        return $this->returnViewWithData($notifications, $userId, $switchUserWork);
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

    public function getTeamInvites($userId){
        $teamInvites = $invites = InviteRequestLinktable::select("*")->where("user_id", $userId)->where("accepted", 0)->get();
        return view("/public/shared/teamInvitesHeaderBox/_popoverData", compact("teamInvites"));
    }
}