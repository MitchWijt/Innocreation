<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollowingTopicsLinktable extends Model
{
    public $table = "user_following_topics_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function forumMainTopic(){
        return $this->hasOne("\App\ForumMainTopic", "id","forum_main_topic_id");
    }
}
