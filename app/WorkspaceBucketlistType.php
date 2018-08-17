<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceBucketlistType extends Model
{
   public $table = "workspace_bucketlist_type";

    public function getWorkspaceBucketlist($team_id)
    {
        return WorkspaceBucketlist::select("*")->where("workspace_bucketlist_type", $this->id)->where("team_id", $team_id)->orderBy("place")->get();
    }
}
