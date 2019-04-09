<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 25/03/2019
 * Time: 18:06
 */
namespace App\Services\Packages;
use App\MembershipPackage;

class MembershipPackageService {

    public static function getFunctionsPackage($packageId){
        $membershipPackage = MembershipPackage::select("*")->where("id", $packageId)->first();
        $functions = explode(",", $membershipPackage->description);
        return $functions;
    }

    public function getFunctionsModel($package){
        $functions = self::getFunctionsPackage($package->id);
        $membershipPackage = MembershipPackage::select("*")->where("id", $package->id)->first();
        return view("/public/checkout/shared/_packageFunctionsModal", compact("functions", "membershipPackage"));
    }
}