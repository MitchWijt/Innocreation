<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWorkInterestsLinktable extends Model
{
    public $table = "userwork_interests_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public static function boot(){
        parent::boot();
        self::created(function($model) {
            $model->created_at = date("Y-m-d H:i:s");
            $model->save();
        });
    }
}
