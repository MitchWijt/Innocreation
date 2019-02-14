<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 14/01/2019
 * Time: 21:25
 */
namespace App\Services\UserConnections;
use App\ConnectRequestLinktable;
use App\User;
use Illuminate\Support\Facades\Session;

class ConnectionService
{
    public function connectionModal($request, $switchUserWork){
        $userId = $request->input("userId");
        $connections = $switchUserWork->listAcceptedConnections($userId);
        $loggedIn = User::select("*")->where("id", Session::get("user_id"))->first();
        return view("/public/shared/connections/_connectionModal", compact("userId", "connections", 'loggedIn'));
    }

    public static function getPopoverSwitchView($receiver, $user = false){
        if(Session::has("user_id")){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/shared/switch/_popoverSwitch", compact("user", "receiver"));
        } else {
            return view("/public/shared/switch/_popoverSwitch", compact( "receiver"));
        }

    }

    public static function getSwitch($receiverUserId){
        $receiver = User::select("*")->where("id", $receiverUserId)->first();
        return view("/public/shared/connections/_switch", compact("receiver"));
    }

    public static function acceptedConnections($userId){
        $connections = ConnectRequestLinktable::select("*")
                      ->where("receiver_user_id", $userId)
                      ->orWhere("sender_user_id", $userId)
                      ->where("accepted", 1)
                      ->get();
        return $connections;
    }
}