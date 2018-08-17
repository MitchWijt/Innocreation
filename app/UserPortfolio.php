<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPortfolio extends Model
{
   public $table = "user_portfolio";

   public function getUrl(){
       return "/images/portfolioImages/$this->image";
   }
}
