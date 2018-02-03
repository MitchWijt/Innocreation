<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NeededExpertiseLinktable extends Model
{
    public $table = "needed_expertise_linktable";

    public function expertises(){
        return $this->hasMany("\App\Expertises", "id","expertise_id");
    }

    public function teams(){
        return $this->hasMany("\App\Team", "id","team_id");
    }
}
