<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserworkPointLinktable extends Model
{
    public $table = "userwork_point_linktable";

    public static function boot(){
        parent::boot();
        self::created(function($model) {
            $model->created_at = date("Y-m-d H:i:s");
            $model->save();
        });
    }
}
