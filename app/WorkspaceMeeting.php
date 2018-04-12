<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceMeeting extends Model
{
    public $table = "workspace_meeting";

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");

    }

    public function getAttendees(){
        $meeting_attendees = WorkspaceMeetingAttendee::select("*")->where("meeting_id", $this->id)->get();
        return $meeting_attendees;
    }
}
