<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GetStream;

class UserMessage extends Model{

    public $table = "user_message";

    public static function boot(){
        date_default_timezone_set("Europe/Amsterdam");
        parent::boot();
        self::created(function($model) {
            if($model->sender_user_id == 1){
                $client = new GetStream\Stream\Client(env("STREAM_API"), env("STREAM_SECRET"));
                $messageFeed = $client->feed('user', $model->userChat->receiver->id);
                $timeNow = date("H:i:s");
                $time = (date("g:i a", strtotime($timeNow)));
                $timeSent = $time;

                // Add the activity to the feed
                $data = ["actor" => $model->userChat->receiver->id, "receiver" => 1, "userChat" => $model->user_chat_id, "message" => $model->message, "timeSent" => "$timeSent", "verb" => "userMessage", "object" => "3",];
                $messageFeed->addActivity($data);
            }
        });
    }


    public function users(){
        return $this->hasMany("\App\User", "id","receiver_user_id");
    }

    public function sender(){
        return $this->hasMany("\App\User", "id","sender_user_id");
    }

    public function userChat(){
        return $this->hasOne("\App\UserChat", "id","user_chat_id");

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
