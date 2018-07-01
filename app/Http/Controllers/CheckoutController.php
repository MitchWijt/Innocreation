<?php

namespace App\Http\Controllers;

use App\CustomMembershipPackage;
use App\CustomMembershipPackageType;
use App\MembershipPackage;
use App\ServiceReview;
use App\Country;
use App\Expertises;
use App\Team;
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
    public function selectPackageAction($title) {
        $pageType = "checkout";

        // for register/login
            $countries = Country::select("*")->orderBy("country")->get();
            $expertises = Expertises::select("*")->get();
            $backlink = "/becoming-a-" . lcfirst($title);
            $urlParameter = 1;
//        ==============
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $membershipPackage = MembershipPackage::select("*")->where("title", ucfirst($title))->first();

        if($user && $user->team_id != null){
            $team = Team::select("*")->where("id", $user->team_id)->first();
        }

        if(request()->has('step')) {
            $step = request()->step;
        } else {
            $step = 1;
        }
        if($user){
            return view("/public/checkout/selectPackage", compact("membershipPackage", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
        } else {
            return view("/public/checkout/selectPackage", compact("membershipPackage", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
