<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomMembershipPackageType extends Model
{
    public $table = "custom_membership_package_type";

    public function getCustomPackages(){
        return CustomMembershipPackage::select("*")->where("type", $this->id)->get();
    }
}
