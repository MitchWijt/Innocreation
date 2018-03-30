<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssistanceTicket extends Model
{
    public $table = "assistance_ticket";

    public function task(){
        return $this->hasOne("\App\WorkspaceShortTermPlannerTask", "id","task_id");
    }
    public function receiver(){
        return $this->hasMany("\App\User", "id","receiver_user_id");
    }

    public function creator(){
        return $this->hasMany("\App\User", "id","creator_user_id");
    }

    public function getMessages(){
        $assistanceTicketMessages = AssistanceTicketMessage::select("*")->where("sender_user_id", $this->creator_user_id)->where("receiver_user_id", $this->receiver_user_id)->where("assistance_ticket_id", $this->id)->orWhere("sender_user_id", $this->receiver_user_id)->where("receiver_user_id", $this->creator_user_id)->where("assistance_ticket_id", $this->id)->get();
        return $assistanceTicketMessages;
    }
}
