<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplitTheBillLinktable extends Model
{
    public $table = "split_the_bill_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function membershipPackage(){
        return $this->hasOne("\App\MembershipPackage", "id","membership_package_change_id");
    }

    public function reservedMembershipPackage(){
        return $this->hasOne("\App\MembershipPackage", "id","reserved_membership_package_id");
    }

    public function allAccepted($teamId){
        $splitTheBills = SplitTheBillLinktable::select("*")->where("team_id", $teamId)->where("accepted", 1)->get();
        $team = Team::select("*")->where("id", $teamId)->first();
        if(count($splitTheBills) >= count($team->getMembers())){
            return true;
        } else {
            return false;
        }
    }

    public function getPaymentUrl(){
        $payment = $this->user->getMostRecentOpenPayment()->payment_url;
        return $payment;
    }
}
