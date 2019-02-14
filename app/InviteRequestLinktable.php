<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteRequestLinktable extends Model
{
    public $table = "invite_request_linktable";

    public static function boot(){
        parent::boot();
        self::created(function($model) {
            $model->created_at = date("Y-m-d H:i:s");
            $model->save();
        });
    }


    public function expertises(){
        return $this->hasMany("\App\Expertises", "id","expertise_id");
    }

    public function users(){
        return $this->hasMany("\App\User", "id","user_id");
    }

    public function teams(){
        return $this->hasOne("\App\Team", "id","team_id");
    }
}
