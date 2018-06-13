<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProductLinktable extends Model
{
    public $table = "team_product_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function teamProduct(){
        return $this->hasOne("\App\TeamProduct", "id","team_product_id");
    }

}
