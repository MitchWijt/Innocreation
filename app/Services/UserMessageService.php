<?php
namespace App\Services;
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 12-10-18
 * Time: 18:25
 */
use App\User;
use App\UserMessage;
use Illuminate\Http\Request;
class UserMessageService
{
    public function createMessage(Request $request){
        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = 1;
        $userMessage->time_sent = "2:00 AM";
        $userMessage->message = "test";
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();
    }
}