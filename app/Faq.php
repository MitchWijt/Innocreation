<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public $table = "faq";

    public function faqType(){
        return $this->hasOne("\App\FaqType", "id","faq_type_id");
    }
}
