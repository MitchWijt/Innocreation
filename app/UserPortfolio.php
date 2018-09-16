<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPortfolio extends Model
{
   public $table = "user_portfolio";

   public function getUrl(){
       return "https://space-innocreation.ams3.digitaloceanspaces.com/users/" . $this->user->slug . "/portfolios/$this->image";
   }

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }
}
