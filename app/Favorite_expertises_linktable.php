<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite_expertises_linktable extends Model
{
    public $table = "favorite_expertises_linktable";

    public function expertises(){
        return $this->hasMany("\App\Expertises", "id","expertise_id");
    }

    public function users(){
        return $this->hasMany("\App\User", "id","user_id");
    }
}
