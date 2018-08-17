<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $table = "invoice";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Teams", "id","team_id");
    }

    public function teamPackage(){
        return $this->hasOne("\App\TeamPackage", "id","team_package_id");
    }
}
