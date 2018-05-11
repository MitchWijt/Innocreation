<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumMainTopicType extends Model
{
   public $table = "forum_main_topic_type";


    public function getMainTopics(){
        $mainTopics  = ForumMainTopic::select("*")->where("main_topic_type_id", $this->id)->where("published", 1)->get();
        return $mainTopics;
    }
}
