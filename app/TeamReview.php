<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamReview extends Model
{
    public $table = "team_review";

    public function users(){
        return $this->hasMany("\App\User", "id","writer_user_id");
    }

    public function teams(){
        return $this->hasMany("\App\Team", "id","team_id");
    }
}
