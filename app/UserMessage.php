<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GetStream;

class UserMessage extends Model{
    use GetStream\StreamLaravel\Eloquent\ActivityTrait;
    public $table = "user_message";

    public function activityExtraData()
    {
        return ['is_retweet' => $this->is_retweet];
    }

    public function users(){
        return $this->hasMany("\App\User", "id","receiver_user_id");
    }

    public function sender(){
        return $this->hasMany("\App\User", "id","sender_user_id");
    }

//    public function receivers(){
//        return $this->hasMany("\App\User", "id","sender_user_id");
//    }

    public function getMessages($receiver, $sender){
        $receiver_user_id = $receiver;
        $sender_user_id = $sender;
        $messages = UserMessage::select("*")->where("receiver_user_id", $receiver_user_id)->where("sender_user_id", $sender_user_id)->orWhere("receiver_user_id", $sender_user_id)->where("sender_user_id", $receiver_user_id)->get();
        return $messages;
    }
}
