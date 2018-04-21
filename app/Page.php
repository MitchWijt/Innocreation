<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = "page";

    public function type(){
        return $this->hasOne("\App\PageType", "id","page_type_id");
    }
}
