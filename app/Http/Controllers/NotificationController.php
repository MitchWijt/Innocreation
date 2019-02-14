<?php

namespace App\Http\Controllers;

use App\AssistanceTicket;
use App\Services\AppServices\StreamService;
use App\Services\FeedServices\SwitchUserWork;
use App\SupportTicket;
use App\SupportTicketMessage;
use App\TeamProduct;
use App\User;
use App\Team;
use App\UserChat;
use App\UserMessage;
use App\UserWork;
use Session;
use App\TeamGroupChatLinktable;
use Illuminate\Http\Request;
use App\Services\UserAccount\UserNotifications as userNotifications;

use App\Http\Requests;

class NotificationController extends Controller
{
    public function getNotificationsAction(userNotifications $userNotifications, SwitchUserWork $switchUserWork, StreamService $streamService){
        $userId = Session::get("user_id");
        return $userNotifications->getStreamDataFromUser($userId, $switchUserWork, $streamService);
    }

    public function getMessageNotificationsAction(userNotifications $userNotifications){
        $userId = Session::get("user_id");
        return $userNotifications->getRecentUserchats($userId);
    }

    public function toChatAction(Request $request, userNotifications $userNotifications){
        return $userNotifications->toChat($request->input("userChatId"));
    }

    public function getTeamInvitesAction(Request $request,userNotifications $userNotifications){
        return $userNotifications->getTeamInvites($request->input("user_id"));
    }
}