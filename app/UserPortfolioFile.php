<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPortfolioFile extends Model
{
    public $table = "user_portfolio_file";

    public function portfolio(){
        return $this->hasOne("\App\UserPortfolio", "id","portfolio_id");
    }

    public function getUrl(){
        return "https://space-innocreation.ams3.cdn.digitaloceanspaces.com/users/" . $this->portfolio->user->slug . "/portfolios/$this->dirname/" . $this->getFilename() ;
    }

    public function getFilename(){
        return $this->filename . $this->extension;
    }
}
