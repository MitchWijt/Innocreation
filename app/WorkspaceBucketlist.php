<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceBucketlist extends Model
{
    public $table = "workspace_bucketlist";

    public function team(){
        return $this->hasMany("\App\Team", "id","team_id");
    }

    public function type(){
        return $this->hasMany("\App\WorkspaceBucketlistType", "id","workspace_bucketlist_type");
    }
}
