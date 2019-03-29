<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 27/03/2019
 * Time: 19:52
 */

namespace App\Services\Checkout;


use App\MembershipPackage;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
use Illuminate\Support\Facades\Session;

class SavePaymentInfo {
    public function savePaymentInfo($request, $mollieService){
        $splitTheBill = $request->input("splitTheBill");
        $paymentPreference = $request->input("paymentPreference");
        $teamId = $request->input("team_id");
        $changePackage = $request->input("change_package");

        $membershipPackageId = $request->input("membership_package_id");
        $membershipPackage = MembershipPackage::select("*")->where("id", $membershipPackageId)->first();
        $team = Team::select("*")->where("id", $teamId)->first();

        // saves the existing or new team package and checks for it
        self::saveTeamPackage($team, $membershipPackage, $paymentPreference);

        // reset cancel subscription id in DB from user if needed;
        self::resetCanceledSubUser($team);

        if ($splitTheBill == 1) {
            //saves split the bill linktable from session for every team member to accept it.
            self::saveSplitTheBillLinktable($team, $changePackage);
            $team->split_the_bill = 1;
        } else {
            $team->split_the_bill = 0;
        }
        $team->save();

        if($changePackage == 1 && $splitTheBill == 1){
            $splitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $teamId)->get();
            foreach($splitTheBillLinktables as $splitTheBillLinktable) {
                $splitTheBillLinktable->accepted_change = 0;
                $splitTheBillLinktable->reserved_membership_package_id = self::existingTeamPackage($team)['reservedId'];
                $splitTheBillLinktable->membership_package_change_id = $membershipPackageId;
                $splitTheBillLinktable->save();
            }
            Session::remove("changePackageCustomNull");
            return redirect("my-team/payment-details");
        } else if($changePackage == 1 && $splitTheBill == 0){
            $teamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            $price = $teamPackage->price;

            //Changes the monthly/yearly price of the customer package
            $mollieService->changePackageOfCustomer($team, $price);
        }
        if($changePackage == 1 && $splitTheBill == 1){
            return redirect("my-team/payment-details");
        } else if($changePackage == 1) {
            return redirect("/my-team");
        } else {
            return redirect($request->input("backlink") . "?step=3");
        }
    }

    private static function saveTeamPackage($team, $membershipPackage, $paymentPreference){
        $existingTeamPackage = self::existingTeamPackage($team);
        if ($existingTeamPackage) {
            $teamPackage = $existingTeamPackage['teamPackage'];
            $paymentPreference = $existingTeamPackage['paymentPreference'];
        } else {
            $teamPackage = new TeamPackage();
        }

        if($paymentPreference == "monthly"){
            $price = $membershipPackage->price;
        } else {
            $price = ($membershipPackage->price) * 12 - 25 . ".00";
        }
        $teamPackage->team_id = $team->id;
        $teamPackage->membership_package_id = $membershipPackage->id;
        $teamPackage->custom_team_package_id = null;
        $teamPackage->payment_preference = $paymentPreference;
        $teamPackage->title = $membershipPackage->title;
        $teamPackage->description = $membershipPackage->description;
        $teamPackage->price = $price;
        $teamPackage->created_at = date("Y-m-d H:i:s");
        $teamPackage->updated_at = date("Y-m-d H:i:s");
        $teamPackage->save();
    }

    private static function existingTeamPackage($team){
        $existingTeamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
        if (count($existingTeamPackage) > 0) {
            $reservedId = $existingTeamPackage->membership_package_id;
            $teamPackage = $existingTeamPackage;
            $paymentPreference = $existingTeamPackage->payment_preference;
            return ['reservedId' => $reservedId, 'teamPackage' => $teamPackage, 'paymentPreference' => $paymentPreference];
        } else {
           return false;
        }
    }

    private static function resetCanceledSubUser($team){
        $user = User::select("*")->where("id", $team->ceo_user_id)->first();
        if($user->subscription_canceled == 1){
            $user->subscription_canceled = 0;
            $user->save();
        }
    }

    private static function saveSplitTheBillLinktable($team, $changePackage){
        foreach (Session::get("splitTheBillData") as $key => $value) {
            $existingSplitTheBill = SplitTheBillLinktable::select("*")->where("user_id", $key)->where("team_id", $team->id)->first();
            if (count($existingSplitTheBill) > 0) {
                $splitTheBillLinktable = $existingSplitTheBill;
            } else {
                $splitTheBillLinktable = new SplitTheBillLinktable();
            }
            $splitTheBillLinktable->user_id = $key;
            $splitTheBillLinktable->team_id = $team->id;
            if($changePackage){
                $splitTheBillLinktable->reserved_changed_amount = $value;
            } else {
                $splitTheBillLinktable->amount = $value;
            }
            $splitTheBillLinktable->created_at = date("Y-m-d H:i:s");
            $splitTheBillLinktable->save();
        }
    }
}