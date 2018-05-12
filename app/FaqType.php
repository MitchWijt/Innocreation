<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqType extends Model
{
    public $table = "faq_type";

    public function getFaqs(){
        $faqs =  Faq::select("*")->where("faq_type_id", $this->id)->where("published", 1)->get();
        return $faqs;
    }

}
