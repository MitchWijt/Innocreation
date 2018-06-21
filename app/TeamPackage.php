<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamPackage extends Model
{
    public $table = 'team_package';


    public function team(){
        return $this->hasOne("\App\Teams", "id","team_id");
    }

    public function membershipPackage(){
        return $this->hasOne("\App\MembershipPackage", "id","membership_package_id");
    }

    public function customTeamPackage(){
        return $this->hasOne("\App\CustomTeamPackage", "id","custom_team_package_id");
    }
}
