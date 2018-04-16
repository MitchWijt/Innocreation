<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    public $table = "forum_thread";

    public function forumMainTopic(){
        return $this->hasMany("\App\ForumMainTopic", "id","main_topic_id");
    }

    public function creator(){
        return $this->hasOne("\App\User", "id","creator_user_id");
    }

    public function getReplies(){
        $forumThreadComments = ForumThreadComment::select("*")->where("thread_id", $this->id)->get();
        return $forumThreadComments;
    }
}
