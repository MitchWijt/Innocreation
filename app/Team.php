<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Team extends Model {
    public function users(){
        return $this->hasOne("\App\User", "id","ceo_user_id");
    }

    public function getUrl(){
        return "/team/$this->slug";
    }

    public function getProfilePicture($size = "normal", $rawPath = false){
        if($this->profile_picture != "defaultProfilePicture.png") {
            if($this->extension == null){
                return env("DO_SPACES_URL") . "/teams/$this->slug/profilepicture/$this->team_profile_picture";
            }
            if($rawPath){
                return "teams/$this->slug/profilepicture/$this->team_profile_picture-$size.$this->extension";
            } else {
                return env("DO_SPACES_URL") . "/teams/$this->slug/profilepicture/$this->team_profile_picture-$size.$this->extension";
            }
        } else {
            return "/images/profilePicturesUsers/defaultProfilePicture.png";
        }
    }

    public function getBanner(){
        if($this->banner != "banner-default.jpg") {
            echo env("DO_SPACES_URL") . "/teams/$this->slug/banner/$this->banner";
        } else {
            return "/images/banner-default.jpg";
        }
    }

    public function getMembers(){
        // gets all the members in the current team
        $users = User::select("*")->where("team_id", $this->id)->get();
        return $users;
    }

    public function calculateAge(){
        // returns the age of the team on date of creation
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d",strtotime($this->created_at)));
        $interval = $date->diff($today);
        return $interval->format('%m months, %d days');
    }

    public function getNeededExpertises(){
        // gets the expertise the current team still needs
        $neededExpertises  = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->with("Expertises")->with("Teams")->get();
        return $neededExpertises;
    }

    public function getAmountNeededExpertises() {
        $neededExpertises  = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->where("amount", "!=", 0)->with("Expertises")->with("Teams")->get();
        return count($neededExpertises);
    }

    public function getNeededExpertisesWithoutAcception(){
        // gets the expertise the current team still needs without the accepted members
        $expertisesNoAcception = [];
        $acceptedExpertises = [];
        $expertises = JoinRequestLinktable::select("*")->where("team_id",$this->id)->where("accepted", 1)->get();
        foreach($expertises as $expertise){
            array_push($acceptedExpertises, $expertise->expertise_id);
        }
        $neededExpertises  = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->get();
        foreach($neededExpertises as $neededExpertise){
            if(!in_array($neededExpertise->expertise_id, $acceptedExpertises)){
                array_push($expertisesNoAcception, $neededExpertise->expertise_id);
            }
        }
        $NeededExpertisesNoAcception = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->where("amount", "!=", 0)->whereIn("expertise_id", $expertisesNoAcception)->with("Expertises")->with("Teams")->get();
        return $NeededExpertisesNoAcception;
    }

    public function needsExpertise($expertiseId){
        $neededExpertises = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->where('expertise_id', $expertiseId)->first();
        if($neededExpertises){
            return true;
        } else
            return false;
    }

    public function calculateSupport($stars, $team_id){
        $team = Team::select("*")->where("id", $team_id)->first();
        $support = $team->support;
        if($stars >= 3){
            $positive = true;
        } else {
            $positive = false;
        }

        if($positive){
            if($stars == 3){
                $support = $support + 50;
            } else if($stars == 4){
                $support = $support + 100;
            } else if($stars == 5){
                $support = $support + 200;
            }
        }

        if($positive == false){
            if($stars == 2){
                $support = $support - 20;
            } else if($stars == 1){
                $support = $support - 50;
            }
        }
        return $support;
    }

    public function checkInvite($team_id, $user_id){
        $bool = false;
        $invite = InviteRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
        if(count($invite) > 0){
            $bool = true;
        }
        return $bool;
    }

    public function allowedRequest(){
        $bool = true;
        if(!$this->packageDetails() || !$this->hasPaid()) {
            if (count($this->getMembers()) >= 2) {
                $bool = false;
            } else {
                $bool = true;
            }
        } else {
            if($this->hasPaid()) {
                if($this->packageDetails()->custom_team_package_id == null) {
                    if($this->packageDetails()->membershipPackage->id == 3) {
                        $bool = true;
                    } else if(count($this->getMembers()) >= $this->packageDetails()->membershipPackage->members) {
                        $bool = false;
                    } else {
                        $bool = true;
                    }
                } else {
                    if(count($this->getMembers()) >= $this->packageDetails()->customTeamPackage->members && $this->packageDetails()->customTeamPackage->members != "unlimited") {
                        $bool = false;
                    } else {
                        $bool = true;
                    }
                }
            } else {
                $bool = false;
            }
        }
         return $bool;
    }
    public function packageDetails(){
        $teamPackage = TeamPackage::select("*")->where("team_id",$this->id)->first();
        if($teamPackage){
            return $teamPackage;
        } else {
            return false;
        }
    }


    public function hasPaid(){
        $amount = 0;
        $paymentsAll = Payments::select("*")->where("team_id", $this->id)->get();
        if(count($paymentsAll) < 1){
            return false;
        } else {
            if ($this->split_the_bill == 0) {
                $payment = Payments::select("*")->where("team_id", $this->id)->orderBy('created_at', 'DESC')->First();
                if ($payment->payment_status == "paid") {
                    $amount = $payment->amount;
                }
            } else {
                $recentPayment = Payments::select("*")->where("team_id", $this->id)->orderBy("created_at", "DESC")->first();
                $payments = Payments::select("*")->where("team_id", $this->id)->get();
                foreach ($payments as $payment) {
                    if (date("Y-m", strtotime($payment->created_at)) == date("Y-m", strtotime($recentPayment->created_at)))
                        if ($payment->payment_status == "paid") {
                            $amount = $amount + $payment->amount;
                        }
                }
            }
            $teamPackage = TeamPackage::select("*")->where("team_id", $this->id)->First();
            if (number_format($amount, 0, ".", ".") >= number_format($teamPackage->price, 2, ".", ".")) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function allowedChange(){
        $teamPackage = TeamPackage::select("*")->where("team_id", $this->id)->first();
        if($teamPackage->change_package == 1 || $teamPackage->changed_payment_settings == 1){
            return false;
        } else {
            if($this->hasPaid()){
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkNeededExpertises($expertiseIds){
        $neededExpertises = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->whereIn("expertise_id", $expertiseIds)->get();
        if(count($neededExpertises) > 0){
            return true;
        } else {
            return false;
        }
    }

}
