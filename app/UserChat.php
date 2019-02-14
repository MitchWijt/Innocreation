<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    public $table = "user_chat";

    public function creator(){
        return $this->hasOne("\App\User", "id","creator_user_id");
    }

    public function receiver(){
        return $this->hasOne("\App\User", "id","receiver_user_id");
    }

    public function getMessages(){
        return UserMessage::select("*")->where("user_chat_id", $this->id)->get();
    }

    public function getUnreadMessages($id){
        return count(UserMessage::select("*")->where("user_chat_id", $this->id)->where("sender_user_id", "!=", $id)->where("seen_at", null)->get());
    }

    public function getMostRecentMessage(){
        return UserMessage::select("*")->where("user_chat_id", $this->id)->orderBy("created_at", "desc")->first();
    }
}
