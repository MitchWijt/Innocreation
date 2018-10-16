<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectRequestLinktable extends Model
{
    public $table = "connect_request_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","receiver_user_id");
    }

    public function sender(){
        return $this->hasOne("\App\User", "id","sender_user_id");
    }
}
