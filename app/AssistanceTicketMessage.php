<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssistanceTicketMessage extends Model
{
   public $table = "assistance_ticket_message";

    public function users(){
        return $this->hasMany("\App\User", "id","receiver_user_id");
    }

    public function sender(){
        return $this->hasMany("\App\User", "id","sender_user_id");
    }

    public function assistanceTicket(){
        return $this->hasMany("\App\AssistanceTicket", "id","assistance_ticket_id");
    }
}
