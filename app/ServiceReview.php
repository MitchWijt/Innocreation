<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    public $table = "service_review";

    public function users(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function supportTicket(){
        return $this->hasOne("\App\SupportTicket", "id","ticket_id");
    }

    public function serviceReviewType(){
        return $this->hasOne("\App\ServiceReviewType", "id","service_review_type_id");
    }
}
