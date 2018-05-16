<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomMembershipPackage extends Model
{
    public $table = "custom_membership_package";

    public function type(){
        return $this->hasOne("\App\CustomMembershipPackageType", "id","type");
    }
}
