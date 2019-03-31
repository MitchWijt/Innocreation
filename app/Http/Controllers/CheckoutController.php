<?php

namespace App\Http\Controllers;

use App\CustomMembershipPackage;
use App\CustomMembershipPackageType;
use App\CustomTeamPackage;
use App\Invoice;
use App\MembershipPackage;
use App\Payments;
use App\ServiceReview;
use App\Country;
use App\Expertises;
use App\Services\AppServices\MailgunService;
use App\Services\AppServices\MollieService;
use App\Services\Checkout\AuthorisePaymentRequest;
use App\Services\Checkout\SavePaymentInfo;
use App\Services\Checkout\SaveUserFromCheckout;
use App\Services\Packages\MembershipPackageService;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\UserChat;
use App\UserMessage;

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
        $title = "Pricing list. Create your free account!";
        $og_description = "The complete pricing list. Create your free account today and start buidling your dream";
        $membershipPackages = MembershipPackage::select("*")->get();
        $customMembershipPackageTypes = CustomMembershipPackageType::select("*")->get();
        $serviceReviews = ServiceReview::select("*")->where("service_review_type_id", 2)->get();
        if (Session::has("user_id")) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/checkout/pricing", compact("membershipPackages", "customMembershipPackageTypes", "serviceReviews", "user", "title", "og_description"));
        } else {
            return view("/public/checkout/pricing", compact("membershipPackages", "customMembershipPackageTypes", "serviceReviews", "title", "og_description"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectPackageAction($title = null)
    {
        $pageType = "checkout";

        // for register/login
        $countries = Country::select("*")->orderBy("country")->get();
        $expertises = Expertises::select("*")->get();
        $backlink = "/becoming-a-" . lcfirst($title);
        $urlParameter = 1;
//        ==============
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $membershipPackage = MembershipPackage::select("*")->where("title", ucfirst($title))->first();

        if (request()->has('step')) {
            $step = request()->step;
            if ($step == 3) {
                $team = Team::select("*")->where("id", $user->team_id)->first();
                $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
            }
            if($step == 2){
                if($user->isMember()){
                    $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                }
            }
        } else {
            $step = 1;
        }


        if ($user && $user->team_id != NULL) {
            $team = Team::select("*")->where("id", $user->team_id)->first();
            if (isset($team) && $user->id != $user->team->ceo_user_id) {
                return redirect($user->getUrl())->withErrors("You are in a team but aren't a team leader. Only team leaders can purchase packages");
            }
        }
        if($step == 1) {
            if ($user && $user->hasValidSubscription()) {
                $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                if (isset($teamPackage) && $teamPackage->change_package == 0) {
                    return redirect($user->getUrl())->withErrors("It seems your team already has a package!");
                }
            }
        }


        if ($user) {
            if ($step == 2 && $user->isMember() && count($teamPackage) > 0) {
                return view("/public/checkout/selectPackage", compact("membershipPackage", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team", "teamPackage"));
            } else {
                return view("/public/checkout/selectPackage", compact("membershipPackage", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
            }
        } else {
            if ($step == 3) {
                return view("/public/checkout/selectPackage", compact("membershipPackage", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team", "paymentMethods"));
            } else {
                return view("/public/checkout/selectPackage", compact("membershipPackage", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
            }
        }
    }

    public function authorisePaymentRequestAction(Request $request, AuthorisePaymentRequest $authorisePaymentRequest, MailgunService $mailgunService) {
        return $authorisePaymentRequest->authorisePaymentRequest($request, $mailgunService);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserFromCheckoutAction(Request $request, SaveUserFromCheckout $saveUserFromCheckout) {
        return $saveUserFromCheckout->saveUser($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function packagePricePreferenceAction(Request $request)
    {
        $packageId = $request->input("package_id");
        $pereference = $request->input("preference");

        $membershipPackage = MembershipPackage::select("*")->where("id", $packageId)->first();
        if ($pereference == "monthly") {
            $price = $membershipPackage->getPrice();
        } else {
            $price = $membershipPackage->getPrice(true);
        }

        return $price;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function setSplitTheBillDataAction(Request $request)
    {
        Session::forget("splitTheBillData");
        $teamId = $request->input("teamId");
        $userIds = $request->input("userIds");
        $prices = $request->input("prices");
        for ($i = 0; $i < count($userIds); $i++) {
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function savePaymentInfoAction(Request $request, MollieService $mollieService, SavePaymentInfo $savePaymentInfo) {
        return $savePaymentInfo->savePaymentInfo($request, $mollieService);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function setDataCustomPackageAction(Request $request)
    {

        $changePackage = $request->input("changePackage");
        $types = $request->input("types");
        $options = $request->input("amountValues");
        for ($i = 0; $i < count($options); $i++) {
            $optionsArray[$types[$i]] = $options[$i];
        }

        $price = 0;
        foreach ($optionsArray as $key => $value) {
            $customMembershipPackage = CustomMembershipPackage::select("*")->where("type", $key)->where("option", $value)->first();
            $price = $price + $customMembershipPackage->price;
        }
        $customPackagesArray = ["options" => $optionsArray, "price" => $price];
        Session::set("customPackagesArray", $customPackagesArray);
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        if($changePackage == 1 && $user->team->split_the_bill == 1){
            $teamId = $user->team_id;
            $teamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            $teamPackage->change_package = 1;
            $teamPackage->save();
        }
        return redirect("/create-custom-package");

    }

    public function donePaymentAction()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

        return view("/public/checkout/donePayment", compact("user", "teamPackage"));
    }

    public function splitTheBillNotification()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

        $paymentTable =  $user->getMostRecentPayment();


        return view("/public/checkout/splitTheBillNotification", compact("user", "teamPackage"));

    }


    public function getChangePackageModalAction(Request $request){
        $userId = $request->input("user_id");
        $membershipPackageId = $request->input("membership_package_id");
        $user = User::select("*")->where("id", $userId)->first();

        if($membershipPackageId == "custom"){
            return view("/public/checkout/shared/changePackageModalData", compact("user"));
        }
        if ($membershipPackageId) {
            $membershipPackage = MembershipPackage::select("*")->where("id", $membershipPackageId)->first();
            return view("/public/checkout/shared/changePackageModalData", compact("user", "membershipPackage"));
        } else {
            return view("/public/checkout/shared/changePackageModalData", compact("user"));
        }
    }

    public function changePackageAction(Request $request){
        $teamId = $request->input("team_id");
        $team = Team::select("*")->where("id", $teamId)->first();
//        if($team->split_the_bill == 1) {
            $teamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            $teamPackage->change_package = 1;
            $teamPackage->save();
//        }

        $title = $request->input("title");
        return redirect("/becoming-a-$title");
    }

    public function getFunctionsModalAction(Request $request, MembershipPackageService $membershipPackageService){
        $membershipPackage = MembershipPackage::select("*")->where("id", $request->input("membership_package_id"))->first();
        return $membershipPackageService->getFunctionsModel($membershipPackage);
    }
}


