<?php

namespace App\Http\Controllers;

use App\CustomMembershipPackage;
use App\CustomMembershipPackageType;
use App\MembershipPackage;
use App\ServiceReview;
use App\Country;
use App\Expertises;
use App\Team;
use App\TeamPackage;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pricingAction()
    {
        Session::remove("customPackagesArray");
        $membershipPackages = MembershipPackage::select("*")->get();
        $customMembershipPackageTypes = CustomMembershipPackageType::select("*")->get();
        $serviceReviews = ServiceReview::select("*")->where("service_review_type_id", 2)->get();
        return view("/public/checkout/pricing", compact("membershipPackages", "customMembershipPackageTypes", "serviceReviews"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectPackageAction($title = null) {
        $pageType = "checkout";

        if(!Session::has("customPackagesArray")) {
            // for register/login
            $countries = Country::select("*")->orderBy("country")->get();
            $expertises = Expertises::select("*")->get();
            $backlink = "/becoming-a-" . lcfirst($title);
            $urlParameter = 1;
//        ==============
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $membershipPackage = MembershipPackage::select("*")->where("title", ucfirst($title))->first();

            if ($user && $user->team_id != null) {
                $team = Team::select("*")->where("id", $user->team_id)->first();
            }

            if (request()->has('step')) {
                $step = request()->step;
            } else {
                $step = 1;
            }

            if ($user) {
                return view("/public/checkout/selectPackage", compact("membershipPackage", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
            } else {
                return view("/public/checkout/selectPackage", compact("membershipPackage", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
            }
        } else {
            $countries = Country::select("*")->orderBy("country")->get();
            $expertises = Expertises::select("*")->get();
            $backlink = "/creating-custom-package";
            $urlParameter = 1;

            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if ($user && $user->team_id != null) {
                $team = Team::select("*")->where("id", $user->team_id)->first();
            }

            if (request()->has('step')) {
                $step = request()->step;
            } else {
                $step = 1;
            }

            $values = [];
            $options = [];
            foreach(Session::get("customPackagesArray")["options"] as $key => $value){
                array_push($values, $value);
                array_push($options, $key);
            }
            for($i = 0; $i < count($values); $i++){
                $customMembershipType = CustomMembershipPackageType::select("*")->where("id", $options[$i])->first();
                $customPackageData[$customMembershipType->title] = $values[$i];
            }
            return view("/public/checkout/selectPackage", compact("customPackageData", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserFromCheckoutAction(Request $request)
    {
        $userId = $request->input("user_id");
        $user = User::select("*")->where("id", $userId)->first();

        $firstname = $request->input("firstname");
        $middlename = $request->input("middlename");
        $lastname = $request->input("lastname");
        $email = $request->input("email");
        $city = $request->input("city");
        $postalcode = $request->input("postcode");
        $state = $request->input("state");
        $country = $request->input("country");
        $phonenumber = $request->input("phonenumber");

        if($request->input("team_name")) {
            $team_name = $request->input("team_name");
            $all_teams = Team::select("*")->where("team_name", $team_name)->get();
            if (count($all_teams) != 0) {
                $error = "This name already exists";
                return view("/public/user/teamBenefits", compact("error", "user"));
            } else {
                $team = new Team;
                $team->team_name = ucfirst($team_name);
                $team->slug = str_replace(" ", "-", strtolower($team_name));
                $team->ceo_user_id = $userId;
                $team->created_at = date("Y-m-d H:i:s");
                $team->team_profile_picture = "defaultProfilePicture.png";
                $team->save();

                Session::set("team_id", $team->id);
                Session::set("team_name", $team->team_name);
            }
        }

        $user->firstname = $firstname;
        $user->middlename = $middlename;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->city = $city;
        $user->postalcode = $postalcode;
        $user->state = $state;
        $user->country = $country;
        $user->phonenumber = $phonenumber;
        if($request->input("team_name")) {
            $user->team_id = $team->id;
        }
        $user->save();

        return redirect($request->input("backlink") . "?step=2");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function packagePricePreferenceAction(Request $request) {
        $packageId = $request->input("package_id");
        $pereference = $request->input("preference");

        $membershipPackage = MembershipPackage::select("*")->where("id", $packageId)->first();
        if($pereference == "monthly"){
            $price = $membershipPackage->getPrice();
        } else {
            $price = $membershipPackage->getPrice(true);
        }
        return $price;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setSplitTheBillDataAction(Request $request) {
        Session::forget("splitTheBillData");
        $teamId = $request->input("teamId");
        $userIds = $request->input("userIds");
        $prices = $request->input("prices");
        for($i = 0; $i < count($userIds); $i++){
            $splitTheBillArray[$userIds[$i]] = $prices[$i];
        }
        Session::set("splitTheBillData", $splitTheBillArray);
        $team = Team::select("*")->where("id", $teamId)->first();
        $team->split_the_bill = 1;
        $team->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function savePaymentInfoAction(Request $request) {
        $splitTheBill = $request->input("splitTheBill");
        $paymentPreference = $request->input("paymentPreference");
        $teamId = $request->input("team_id");

        $membershipPackageId = $request->input("membership_package_id");
        $membershipPackage = MembershipPackage::select("*")->where("id", $membershipPackageId)->first();

        $existingTeamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
        if(count($existingTeamPackage) > 0){
            $teamPackage = $existingTeamPackage;
        } else {
            $teamPackage = new TeamPackage();
        }
        $teamPackage->team_id = $teamId;
        $teamPackage->membership_package_id = $membershipPackageId;
        $teamPackage->payment_preference = $paymentPreference;
        $teamPackage->title = $membershipPackage->title;
        $teamPackage->description = $membershipPackage->description;
        $teamPackage->price = $membershipPackage->price;
        $teamPackage->created_at = date("Y-m-d H:i:s");
        $teamPackage->updated_at = date("Y-m-d H:i:s");
        $teamPackage->save();

        $team = Team::select("*")->where("id", $teamId)->first();
        if($splitTheBill == 1) {
            $team->split_the_bill = 1;
        } else {
            $team->split_the_bill = 0;
        }
        $team->save();
        return redirect($request->input("backlink") . "?step=3");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setDataCustomPackageAction(Request $request) {

        $types = $request->input("types");
        $options = $request->input("amountValues");
        for($i = 0; $i < count($options); $i++){
            $optionsArray[$types[$i]] = $options[$i];
        }

        $price = 0;
        foreach ($optionsArray as $key => $value){
            $customMembershipPackage = CustomMembershipPackage::select("*")->where("type", $key)->where("option", $value)->first();
            $price = $price + $customMembershipPackage->price;
        }
        $customPackagesArray = ["options" => $optionsArray, "price" => $price];
        Session::set("customPackagesArray", $customPackagesArray);
        return redirect("/create-custom-package");

    }
}
