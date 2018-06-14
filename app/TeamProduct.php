<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProduct extends Model
{
    public $table = "team_product";

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function getLikes(){
        $teamProductLinkTable = TeamProductLinktable::select("*")->where("team_product_id", $this->id)->where("liked", 1)->get();
        return count($teamProductLinkTable);
    }

    public function getUrl($fullLink = false){
        if($fullLink){
            return $_SERVER['HTTP_HOST'] . "/team-product/$this->slug";
        } else {
            return "/team-product/$this->slug";
        }
    }

}
