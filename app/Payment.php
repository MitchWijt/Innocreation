<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = "payment";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Teams", "id","team_id");
    }

    public function invoice(){
        return $this->hasOne("\App\Invoice", "id","invoice_id");
    }
}
