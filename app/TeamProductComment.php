<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProductComment extends Model
{
    public $table = "team_product_comment";

    public function user(){
        return $this->hasOne("\App\User", "id","sender_user_id");
    }

    public function teamProduct(){
        return $this->hasOne("\App\TeamProduct", "id","team_product_id");
    }
}
