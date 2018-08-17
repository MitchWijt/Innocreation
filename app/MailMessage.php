<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailMessage extends Model
{
   public $table = "mail_message";

   public function users(){
       return $this->hasOne("\App\User", "id","receiver_user_id");
   }

}
