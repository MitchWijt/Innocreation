<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerIdea extends Model
{
    public $table = "customer_idea";

    public function users(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function status(){
        return $this->hasOne("\App\CustomerIdeaStatus", "id","customer_idea_status_id");
    }
}
