<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceMeetingAttendee extends Model
{
    public $table = "workspace_meeting_attendee";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function meeting(){
        return $this->hasMany("\App\WorkspaceMeeting", "id","meeting_id");
    }
}
