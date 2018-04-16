<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumMainTopic extends Model
{
    public $table = "forum_main_topic";

    public function type(){
        return $this->hasOne("\App\ForumMainTopicType", "id","main_topic_type_id");
    }

    public function getAmountPosts(){
        $forumThreads = ForumThread::select("*")->where("main_topic_id", $this->id)->get();
        return $forumThreads;
    }

}
