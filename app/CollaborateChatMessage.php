<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollaborateChatMessage extends Model{
    public $table = "collaborate_chat_message";

    public function user(){
        return $this->hasOne("\App\User", "id","sender_user_id");
    }
}
