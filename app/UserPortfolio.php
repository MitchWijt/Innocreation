<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPortfolio extends Model
{
   public $table = "user_portfolio";

   public function getUrl(){
       return "https://space-innocreation.ams3.cdn.digitaloceanspaces.com/users/" . $this->user->slug . "/portfolios/" . $this->getDirName();
   }


    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function getFiles(){
        $userPortfolioFiles = UserPortfolioFile::select("*")->where("portfolio_id", $this->id)->get();
        if($userPortfolioFiles) {
            return $userPortfolioFiles;
        }
    }

    public function getDirName(){
        return strtolower(str_replace(" ","-", $this->title));
    }
}
