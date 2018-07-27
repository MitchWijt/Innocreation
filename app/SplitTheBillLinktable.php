<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplitTheBillLinktable extends Model
{
    public $table = "split_the_bill_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }
}
