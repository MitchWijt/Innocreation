<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertises_linktable extends Model
{
    public $table = 'expertises_linktable';

    public static function boot(){
        date_default_timezone_set("Europe/Amsterdam");
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
}
