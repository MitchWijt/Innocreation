<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = "page";

    public function type(){
        return $this->hasOne("\App\PageType", "id","page_type_id");
    }

    public function getUrl(){
        return "/page/$this->slug";
    }
}
