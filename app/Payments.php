<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    public $table = "payments";

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
