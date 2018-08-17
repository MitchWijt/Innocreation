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

    public function getNewThreads($seen_at){
        $newThreads = [];
        $threads = ForumThread::select("*")->where("main_topic_id", $this->id)->get();
        foreach($threads as $thread){
            if(strtotime(date("Y-m-d H:i:s", strtotime($thread->created_at))) > strtotime(date("Y-m-d H:i:s", strtotime($seen_at)))){
                array_push($newThreads, $thread);
            }
        }
        return $newThreads;
    }

    public function getUrl(){
        return "/forum/topic/$this->id";
    }

}
