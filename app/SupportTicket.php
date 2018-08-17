<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    public $table = "support_ticket";

    public function users(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function helper(){
        return $this->hasOne("\App\User", "id","helper_user_id");
    }

    public function supportTicketStatus(){
        return $this->hasOne("\App\SupportTicketStatus", "id","support_ticket_status_id");
    }

    public function getMessages(){
        $messages = SupportTicketMessage::select("*")->where("support_ticket_id", $this->id)->get();
        return $messages;
    }
}
