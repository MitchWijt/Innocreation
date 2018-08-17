<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicketMessage extends Model
{
    public $table = "support_ticket_message";

    public function sender(){
        return $this->hasOne("\App\User", "id","sender_user_id");
    }

    public function supportTicket(){
        return $this->hasOne("\App\SupportTicket", "id","support_ticket_id");
    }
}
