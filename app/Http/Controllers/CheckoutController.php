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
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
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
        $membershipPackages = MembershipPackage::select("*")->get();
        $customMembershipPackageTypes = CustomMembershipPackageType::select("*")->get();
        $serviceReviews = ServiceReview::select("*")->where("service_review_type_id", 2)->get();
        if (Session::has("user_id")) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/checkout/pricing", compact("membershipPackages", "customMembershipPackageTypes", "serviceReviews", "user"));
        } else {
            return view("/public/checkout/pricing", compact("membershipPackages", "customMembershipPackageTypes", "serviceReviews"));
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

        if (!Session::has("customPackagesArray")) {
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
                if($user->id != $user->team->ceo_user_id){
                    return redirect("/my-account")->withErrors("You are in a team but aren't a team leader. Only team leaders can purchase packages");
                }
            }

            if (request()->has('step')) {
                $step = request()->step;
                if ($step == 3) {
                    $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
                    $HMAC_KEY = "BA15F61D808D61044A97167A6F00732C0144E7BB020900389CE8560739AF88E0";
                    $binaryHmacKey = pack("H*", $HMAC_KEY);
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
                if($step == 2){
                    if($user->isMember()){
                        $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                    }
                }
            } else {
                $step = 1;
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

                if($step == 2){
                    if($user->isMember()){
                        $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
                    }
                }
            } else {
                $step = 1;
            }

            $values = [];
            $options = [];
            foreach (Session::get("customPackagesArray")["options"] as $key => $value) {
                array_push($values, $value);
                array_push($options, $key);
            }
            for ($i = 0; $i < count($values); $i++) {
                $customMembershipType = CustomMembershipPackageType::select("*")->where("id", $options[$i])->first();
                $customPackageData[$customMembershipType->title] = $values[$i];
            }
            if ($step == 2 && $user->isMember() && count($teamPackage) > 0) {
                return view("/public/checkout/selectPackage", compact("customPackageData", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team", "teamPackage"));
            } else {
                return view("/public/checkout/selectPackage", compact("customPackageData", "user", "pageType", "countries", "expertises", "backlink", "urlParameter", "step", "team"));
            }
        }
    }

    public function authorisePaymentRequestAction(Request $request)
    {
        $encryptedData = $request->input("adyen-encrypted-data");

        //Save encrypted credit card info to user
        $user = User::select("*")->where("id", Session::get("user_id"))->first();

        //Get team and teampackage + declare price
        $team = Team::select("*")->where("id", $request->input("team_id"))->first();
        $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();
        if ($team->split_the_bill == 0) {
            if (!Session::has("customPackagesArray")) {
                $price = str_replace(".", "", number_format($teamPackage->price, 2, ".", "."));
            } else {
                $price = str_replace(".", "", number_format(\Illuminate\Support\Facades\Session::get("customPackagesArray")["price"], 2, ".", "."));
            }
        } else {
            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("team_id", $request->input("team_id"))->where("user_id", $user->id)->first();
            $splitTheBillLinktable->accepted = 1;
            $splitTheBillLinktable->save();

            $price = str_replace(".", "", number_format($splitTheBillLinktable->amount, 2, ".", "."));
        }

            $payment = Payments::select("*")->orderBy("id", "DESC")->first();
            $reference = $payment->reference + 1;


            //RECURRINGSTORECALL
            $data = array("additionalData" => array("card.encrypted.json" => $encryptedData), "amount" => array("value" => $price, "currency" => "EUR"), "reference" => $reference, "merchantAccount" => "InnocreationNET", "shopperReference" => $team->users->getName() . $team->id, "recurring" => array("contract" => "RECURRING"));
            $data_string = json_encode($data);

            $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
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

            $resultCode = $resultAuthorization->resultCode;
            $pspReference = $resultAuthorization->pspReference;
            //close connection
            curl_close($ch);
            if ($resultCode == "Refused") {
                $payment = new Payments();
                $payment->user_id = $team->users->id;
                $payment->team_id = $team->id;
                $payment->amount = $price;
                $payment->recurring_detail_reference = null;
                $payment->shopper_reference = $team->users->getName() . $team->id;
                $payment->reference = $reference;
                $payment->pspReference = $pspReference;
                $payment->payment_status = "Canceled";
                $payment->created_at = date("Y-m-d H:i:s");
                $payment->save();

                $data = array("merchantAccount" => "InnocreationNET", "originalReference" => $pspReference);
                $data_string = json_encode($data);

                $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
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
                //close connection
                curl_close($ch);
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("Your credit card credentials seem to be invalid, to continue check your credentials and please try again");
            } else {
                //RECURRINGDETAILS
                $data = array("merchantAccount" => "InnocreationNET", "shopperReference" => $team->users->getName() . $team->id);
                $data_string = json_encode($data);

                $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Recurring/v25/listRecurringDetails');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
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

                $recurringDetailReference = $resultAuthorization->details[0]->RecurringDetail->recurringDetailReference;

                //close connection
                curl_close($ch);

                $details = end($resultAuthorization->details);
                $card = $details->RecurringDetail->card;
                $paymentMethod = $details->RecurringDetail->paymentMethodVariant;

                $payment = new Payments();
                $payment->user_id = $team->users->id;
                $payment->team_id = $team->id;
                $payment->payment_method = $paymentMethod;
                $payment->card_number = $card->number;
                $payment->amount = $price;
                $payment->recurring_detail_reference = $recurringDetailReference;
                $payment->shopper_reference = $team->users->getName() . $team->id;
                $payment->reference = $reference;
                $payment->pspReference = $pspReference;
                if($team->split_the_bill == 1){
                    $payment->payment_status = "Authorized";
                } else {
                    $payment->payment_status = "Settled";
                }
                $payment->created_at = date("Y-m-d H:i:s");
                $payment->save();

                if($team->split_the_bill == 1){
                    $splitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $team->id)->get();
                    foreach ($splitTheBillLinktables as $splitTheBillLinktable) {
                        $user = User::select("*")->where("id", $splitTheBillLinktable->user_id)->first();
                        $this->saveAndSendEmail($splitTheBillLinktable->user, $team->team_name . " wants to split the bil!", view("/templates/sendSplitTheBillNotification", compact("user", "team")));

                        $userChat = UserChat::select("*")->where("receiver_user_id", $splitTheBillLinktable->user_id)->where("creator_user_id", 1)->first();
                        $userMessage = new UserMessage();
                        $userMessage->sender_user_id = 1;
                        $userMessage->user_chat_id = $userChat->id;
                        $userMessage->time_sent = $this->getTimeSent();
                        $userMessage->message = "$team->team_name has chosen to split the bill with you and your members! Verify the request at payment details in your account to benefit from the package even quiker!";
                        $userMessage->created_at = date("Y-m-d H:i:s");
                        $userMessage->save();
                    }
                    return redirect("/almost-there");
                } else {
                    $invoiceNumber = Invoice::select("*")->orderBy("invoice_number", "DESC")->first()->invoice_number;
                    $invoice = new Invoice();
                    $invoice->user_id = $user->id;
                    $invoice->team_id = $team->id;
                    $invoice->team_package_id = $teamPackage->id;
                    $invoice->amount = number_format($teamPackage->price, 2, ".", ".");
                    $invoice->hash = $user->hash;
                    $invoice->invoice_number = $invoiceNumber + 1;
                    $invoice->paid_date = date("Y-m-d", strtotime("+2 days"));
                    $invoice->created_at = date("Y-m-d H:i:s");
                    $invoice->save();
                    return redirect("/thank-you");
                }

            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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

        if ($request->input("team_name")) {
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
        if ($request->input("team_name")) {
            $user->team_id = $team->id;
        }
        $user->save();

        return redirect($request->input("backlink") . "?step=2");
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
    public function savePaymentInfoAction(Request $request)
    {
        $splitTheBill = $request->input("splitTheBill");
        $paymentPreference = $request->input("paymentPreference");
        $teamId = $request->input("team_id");
        $changePackage = $request->input("change_package");

        $membershipPackageId = $request->input("membership_package_id");

        if ($membershipPackageId != "custom") {
            $membershipPackage = MembershipPackage::select("*")->where("id", $membershipPackageId)->first();

            $existingTeamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            if (count($existingTeamPackage) > 0) {
                if($existingTeamPackage->custom_team_package_id == null){
                    $reservedId = $existingTeamPackage->membership_package_id;
                } else {
                    $reservedId = $existingTeamPackage->custom_team_package_id;
                }
                $teamPackage = $existingTeamPackage;
            } else {
                $teamPackage = new TeamPackage();
            }
            $teamPackage->team_id = $teamId;
            $teamPackage->membership_package_id = $membershipPackageId;
            $teamPackage->custom_team_package_id = null;
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
            foreach (Session::get("customPackagesArray")["options"] as $key => $value) {
                if ($key == 1) {
                    $customTeamPackage->members = $value;
                } else if ($key == 2) {
                    $customTeamPackage->planners = $value;
                } else if ($key == 3) {
                    $customTeamPackage->meetings = $value;
                } else if ($key == 4) {
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
        if ($splitTheBill == 1) {
            foreach (Session::get("splitTheBillData") as $key => $value) {
                $existingSplitTheBill = SplitTheBillLinktable::select("*")->where("user_id", $key)->where("team_id", $teamId)->first();
                if (count($existingSplitTheBill) > 0) {
                    $splitTheBillLinktable = $existingSplitTheBill;
                } else {
                    $splitTheBillLinktable = new SplitTheBillLinktable();
                }
                $splitTheBillLinktable->user_id = $key;
                $splitTheBillLinktable->team_id = $teamId;
                if($changePackage){
                    $splitTheBillLinktable->reserved_changed_amount = $value;
                } else {
                    $splitTheBillLinktable->amount = $value;
                }
                $splitTheBillLinktable->created_at = date("Y-m-d H:i:s");
                $splitTheBillLinktable->save();
            }
            $team->split_the_bill = 1;
        } else {
            $team->split_the_bill = 0;
        }
        $team->save();

        if($changePackage == 1 && $splitTheBill == 1){
            $splitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $teamId)->get();
            foreach($splitTheBillLinktables as $splitTheBillLinktable) {
                $splitTheBillLinktable->accepted_change = 0;
                $splitTheBillLinktable->membership_package_change_id = $membershipPackageId;
                if(!Session::has("customPackagesArray")) {
                    $splitTheBillLinktable->reserved_membership_package_id = $reservedId;
                }
                $splitTheBillLinktable->save();
            }
            return redirect("my-team/payment-details");
        }
        if($changePackage == 1 && $splitTheBill == 1){
            return redirect("my-team/payment-details");
        } else if($changePackage == 1) {
            return redirect("/my-team");
        } else {
            return redirect($request->input("backlink") . "?step=3");
        }
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
        return view("/public/checkout/splitTheBillNotification", compact("user", "teamPackage"));

    }

    public function webhookAction()
    {
        $response = file_get_contents('php://input');
        $json = json_decode($response);
        Session::set("json", $json);
        $data = array("notificationResponse" => "[accepted]");
        $data_string = json_encode($data);


        $ch = curl_init('http://notification.services.adyen.com');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
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
        //close connection
        curl_close($ch);

    }

    public function getChangePackageModalAction(Request $request){
        $userId = $request->input("user_id");
        $membershipPackageId = $request->input("membership_package_id");

        $user = User::select("*")->where("id", $userId)->first();
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
        if($team->split_the_bill == 1) {
            $teamPackage = TeamPackage::select("*")->where("team_id", $teamId)->first();
            $teamPackage->change_package = 1;
            $teamPackage->save();
        }

        $title = $request->input("title");
        if($title == "custom"){
            return redirect("/becoming-a-$title");
        } else {
            return redirect("/becoming-a-$title");
        }

    }
}


