<?php

namespace App\Http\Controllers;

use Adyen\AdyenException;
use Adyen\Service\Payment;
use App\CustomMembershipPackage;
use App\CustomMembershipPackageType;
use App\CustomTeamPackage;
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
                if($step == 3){
                    $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
                    $HMAC_KEY = "BA15F61D808D61044A97167A6F00732C0144E7BB020900389CE8560739AF88E0";
                    $binaryHmacKey = pack("H*" , $HMAC_KEY);
                    $pairs["countryCode"] = $user->countries->country_code;
                    $pairs["shopperLocale"] = "en_GB";
                    $pairs["merchantReference"] = "Package:$teamPackage->id\\$team->id";
                    $pairs["merchantAccount"] = "InnocreationNET";
                    $date = date("Y-m-d");
                    $time = date("H:i:s");
                    $pairs["sessionValidity"] = "$date" . "T" . $time . "Z";
                    $pairs["paymentAmount"] = number_format($teamPackage->price, 0, ".", ".");
                    $pairs["currencyCode"] = "EUR";
                    $pairs["skinCode"] = "iXpfcBwG";

                    $signature = $this->calculateAdyenSignature($pairs, $HMAC_KEY, $binaryHmacKey);

                    $pairs["merchantSig"] = $signature;
                    $queryString = http_build_query($pairs);
                    $testUrl = "https://test.adyen.com/hpp/directory.shtml" . "?" . $queryString;
                    $json = file_get_contents($testUrl);
                    $paymentMethods = json_decode($json);
                }
            } else {
                $step = 1;
            }

            if ($user) {
                if($step == 3){
                    return view("/public/checkout/selectPackage", compact("membershipPackage", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team", "paymentMethods"));
                } else {
                    return view("/public/checkout/selectPackage", compact("membershipPackage", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
                }
            } else {
                if($step == 3){
                    return view("/public/checkout/selectPackage", compact("membershipPackage", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team", "paymentMethods"));
                } else {
                    return view("/public/checkout/selectPackage", compact("membershipPackage", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
                }
            }
        } else {
            $countries = Country::select("*")->orderBy("country")->get();
            $expertises = Expertises::select("*")->get();
            $backlink = "/create-custom-package";
            $urlParameter = 1;

            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if ($user && $user->team_id != null) {
                $team = Team::select("*")->where("id", $user->team_id)->first();
            }

            if (request()->has('step')) {
                $step = request()->step;
                if($step == 3){
                    $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
                    $HMAC_KEY = "BA15F61D808D61044A97167A6F00732C0144E7BB020900389CE8560739AF88E0";
                    $binaryHmacKey = pack("H*" , $HMAC_KEY);
                    $pairs["countryCode"] = $user->countries->country_code;
                    $pairs["shopperLocale"] = "en_GB";
                    $pairs["merchantReference"] = "customPackage:$teamPackage->custom_team_package_id\\$team->id";
                    $pairs["merchantAccount"] = "InnocreationNET";
                    $date = date("Y-m-d");
                    $time = date("H:i:s" , strtotime("+2 hour"));
                    $pairs["sessionValidity"] = "$date" . "T" . $time . "Z";
                    $pairs["paymentAmount"] = number_format(Session::get("customPackagesArray")["price"], 0, ".", ".");
                    $pairs["currencyCode"] = "EUR";
                    $pairs["skinCode"] = "iXpfcBwG";

                    $signature = $this->calculateAdyenSignature($pairs, $HMAC_KEY, $binaryHmacKey);

                    $pairs["merchantSig"] = $signature;
                    $queryString = http_build_query($pairs);
                    $testUrl = "https://test.adyen.com/hpp/directory.shtml" . "?" . $queryString;
                    $json = file_get_contents($testUrl);
                    $paymentMethods = json_decode($json);
                }
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
            if($step == 3){
                return view("/public/checkout/selectPackage", compact("customPackageData", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team", "paymentMethods"));
            } else {
                return view("/public/checkout/selectPackage", compact("customPackageData", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
            }
        }
    }

    public function authorisePaymentRequestAction(Request $request){
        $encryptedData = $request->input("adyen-encrypted-data");
//        $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
//        $HMAC_KEY = "BA15F61D808D61044A97167A6F00732C0144E7BB020900389CE8560739AF88E0";
//        $binaryHmacKey = pack("H*" , $HMAC_KEY);

        $data = array("additionalData" => array("card.encrypted.json" => $encryptedData),"amount" => array("value" => 2000, "currency" => "EUR"), "reference" => "testpaymentCard", "merchantAccount" => "InnocreationNET");
        $data_string = json_encode($data);

//        header('Content-Type: application/json; charset=UTF-8', true);
        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic '. base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                'Content-Type: application/json',
                'Content-Length:' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        //execute post
        $result = curl_exec($ch);
        $resultAuthorization = json_decode($result);
        $pspReference = $resultAuthorization->pspReference;
        //close connection
        curl_close($ch);

        $data = array("merchantAccount" => "InnocreationNET", "modificationAmount" => array("value" => 20000, "currency" => "EUR"), "originalReference" => $pspReference, "reference" => "testCardPayment", "recurring" => array("contract" => "RECURRING, ONECLICK"));
        $data_string = json_encode($data);

//        header('Content-Type: application/json; charset=UTF-8', true);
        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/capture');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic '. base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
                'Content-Type: application/json',
                'Content-Length:' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        //execute post
        $result = curl_exec($ch);
        dd($result);
        //close connection
        curl_close($ch);
//
//        $client = new \Adyen\Client();
//        $client->setUsername("ws@Company.Innocreation");
//        $client->setPassword("[puCnJ5TjHjTxjpa++rI1%UD~");
//        $client->setEnvironment(\Adyen\Environment::TEST);
//        $client->setApplicationName("My Test Application");
//        // initialize service
//
//        $service = new Payment($client);
//        /**
//         * The payment can be submitted by sending a PaymentRequest
//         * to the authorise action of the web service, the request should
//         * contain the following variables:
//         * - merchantAccount            : The merchant account the payment was processed with.
//         * - amount
//         * 	    - currency              : the currency of the payment
//         * 	    - amount                : the amount of the payment
//         * - reference                  : Your reference
//         * - shopperIP                  : The IP address of the shopper (optional/recommended)
//         * - shopperEmail               : The e-mail address of the shopper
//         * - shopperReference           : The shopper reference, i.e. the shopper ID
//         * - fraudOffset                : Numeric value that will be added to the fraud score (optional)
//         * - additionalData
//         *      - card.encrypted.json   : The encrypted card catched by the POST variables.
//         */
//        $amount = array(
//            "value" => 2000,
//            "currency"=> "EUR"
//        );
//        $additionalData = array(
//            "card.encrypted.json" => $encryptedData
//        );
//        $request = array(
//            "merchantAccount" => "InnocreationNET",
//            "amount" => $amount,
//            "reference" => "testCardPayment",
//            "additionalData" => $additionalData
//        );
//        $result = $service->authorise($request);
//        /**
//         * If the payment passes validation a risk analysis will be done and, depending on the
//         * outcome, an authorisation will be attempted. You receive a
//         * payment response with the following fields:
//         * - pspReference              : The reference we assigned to the payment;
//         * - resultCode                : The result of the payment. One of Authorised, Refused or Error;
//         * - authCode                  : An authorisation code if the payment was successful, or blank otherwise;
//         * - refusalReason             : If the payment was refused, the refusal reason.
//         */
//        print_r("Payment Result:\n");
//        print_r("- pspReference: " . $result['pspReference'] . "\n");
//        print_r("- resultCode: " . $result['resultCode']. "\n");
//        print_r("- authCode: " . $result['authCode']. "\n");
//        print_r("- refusalReason: " . $result['refusalReason']. "\n");
//
//        die("gfds");


//        $pairs["reference"] = "testCardPayment";
//        $pairs["merchantAccount"] = "InnocreationNET";
//        $pairs["amount"] = 2000;
//        $queryString = http_build_query($pairs);
//        $testUrl = "https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise" . "?" . $queryString;
//        $json = file_get_contents($testUrl);
//        dd($json);

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

        if($membershipPackageId != "custom") {
            $membershipPackage = MembershipPackage::select("*")->where("id", $membershipPackageId)->first();

            $existingTeamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            if (count($existingTeamPackage) > 0) {
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
        } else {
            $existingCustomTeamPackage = CustomTeamPackage::select("*")->where("team_id", $teamId)->first();
            if (count($existingCustomTeamPackage) > 0) {
                $customTeamPackage = $existingCustomTeamPackage;
            } else {
                $customTeamPackage = new CustomTeamPackage();
            }
            $customTeamPackage->team_id = $teamId;
            foreach(Session::get("customPackagesArray")["options"] as $key => $value){
                if($key == 1){
                    $customTeamPackage->members = $value;
                } else if($key == 2){
                    $customTeamPackage->planners = $value;
                } else if($key == 3){
                    $customTeamPackage->meetings = $value;
                } else if($key == 4){
                    $customTeamPackage->newsletters = $value;
                }
//                $customTeamPackage->dashboard = $value[4];
                $customTeamPackage->created_at = date("Y-m-d H:i:s");
                $customTeamPackage->save();
            }
            $existingTeamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            if (count($existingTeamPackage) > 0) {
                $teamPackage = $existingTeamPackage;
            } else {
                $teamPackage = new TeamPackage();
            }
            $teamPackage->team_id = $teamId;
            $teamPackage->membership_package_id = null;
            $teamPackage->custom_team_package_id = $customTeamPackage->id;
            $teamPackage->payment_preference = $paymentPreference;
            $teamPackage->price = Session::get("customPackagesArray")["price"];
            $teamPackage->created_at = date("Y-m-d H:i:s");
            $teamPackage->updated_at = date("Y-m-d H:i:s");
            $teamPackage->save();
        }

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
