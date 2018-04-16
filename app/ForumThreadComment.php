<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumThreadComment extends Model
{
   public $table = "forum_thread_comment";

    public function thread(){
        return $this->hasMany("\App\ForumThread", "id","thread_id");
    }

    public function creator(){
        return $this->hasMany("\App\User", "id","creator_user_id");
    }
}
