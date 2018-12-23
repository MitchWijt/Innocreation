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
        return env("DO_SPACES_URL") . "/users/" . $this->portfolio->user->slug . "/portfolios/$this->dirname/" . $this->getFilename() ;
    }

    public function getPath(){
        return "users/" . $this->portfolio->user->slug . "/portfolios/$this->dirname/" . $this->getFilename() ;
    }

    public function getFilename(){
        return $this->filename;
    }
}
