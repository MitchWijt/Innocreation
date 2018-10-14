<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 14-10-18
 * Time: 11:05
 */

namespace App\Services;
use App\ConnectRequestLinktable;
use App\User;
use App\UserMessage;
use App\UserWork;

class SwitchUserWork
{
    private $modal;
    private $requestModal;

    public function __construct(UserWork $userWork, ConnectRequestLinktable $connectRequest) {
        $this->modal = $userWork;
        $this->requestModal = $connectRequest;

    }

    public function createNewConnectRequest($request){
        $connectRequest = new $this->requestModal;
        $connectRequest->receiver_user_id = $request->input("receiver_user_id");
        $connectRequest->sender_user_id = $request->input("sender_user_id");
        $connectRequest->user_work_id = $request->input("user_work_id");
        $connectRequest->message = $request->input("connectMessage");
        $connectRequest->accepted = 0;
        $connectRequest->created_at = date("Y-m-d H:i:s");
        $connectRequest->save();

        return json_encode($connectRequest);
    }

}