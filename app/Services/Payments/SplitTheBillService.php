<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 29/03/2019
 * Time: 13:25
 */
namespace App\Services\Payments;
use App\Services\AppServices\MollieService;
use App\Services\GenericService;
use App\SplitTheBillLinktable;
use App\TeamPackage;
use App\User;
use App\Payments;
use App\Services\Payments\PaymentService;
class SplitTheBillService {

    public function validateSplitTheBill($request){
        $userId = $request->input("user_id");
        $termsPayment = $request->input("paymentTermsCheck");
        $termsPrivacy = $request->input("privacyTermsCheck");
        $user = User::select("*")->where("id", $userId)->first();
        $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
        $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

        // returns the unique reference number for the new payment
        $reference = PaymentService::getPaymentReference($userId);

        $price = number_format($splitTheBillLinktable->amount, 2, ".", ".");
        $description = $teamPackage->title . " for team " . $teamPackage->team->team_name . " - " .  $reference . " ";


        //checks if both terms of service and terms of privacy are accepted
        if($termsPayment == 1 && $termsPrivacy == 1){
            //accepts the split the bill.
            if($user->getMostRecentPayment()){
                self::validateWhenRecentPayment($teamPackage, $price, $description, $reference, $user);
            } else if($user->getMostRecentOpenPayment()) {
                $url = $splitTheBillLinktable->getPaymentUrl();
                return redirect($url);
            } else {
                self::validateWhenNewPayment($price, $description, $reference, $user);
            }
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Agree with the Term to continue");
        }
    }


    public static function acceptSplitTheBill($user){
        $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $user->team_id)->first();
        $splitTheBillLinktable->accepted = 1;
        $splitTheBillLinktable->save();
    }

    private static function getPaymentPreference($teamPackage){
        if($teamPackage->payment_preference == "monthly"){
            $range = "1 months";
        } else {
            $range = "12 months";
        }
        return $range;
    }

    private static function getRedirectUrl(){
        $fullDomain = $_SERVER['HTTP_HOST'];
        $domainExplode = explode(".", $fullDomain);
        if($domainExplode[0] == "secret") {
            $redirectUrl = "http://secret.innocreation.net/my-account/payment-details";
        } else {
            $redirectUrl = "http://innocreation.net/my-account/payment-details";
        }

        return $redirectUrl;
    }

    private static function validateWhenRecentPayment($teamPackage, $price, $description, $reference, $user){
        //returns range of payment (12 months or 1 month)
        $range = self::getPaymentPreference($teamPackage);

        // no active subscriptions
        $mollie = new MollieService();
        $customer = $mollie->mollie->customers->get($user->mollie_customer_id);

        $mandates = $customer->mandates();
        if($mandates[0]->status == "valid" || !$user->hasValidSubscription()) {
            // creates new mollie subscription for user.
            $mollie->createNewMollieSubscription($user, $price, $description, $reference, $range);
        }
        $subscriptions = $customer->subscriptions();

        $paymentService = new PaymentService();
        $paymentService->createNewPayment($user, $price, $reference, "paid", "creditcard", $subscriptions[0]->id, false, false);

        $redirect = self::getRedirectUrl();
        return redirect($redirect);
    }

    private static function validateWhenNewPayment($price, $description, $reference, $user){
        // return the redirect url user goes to after payment.
        $redirectUrl = self::getRedirectUrl();

        //Gets the payment reference number
        PaymentService::getPaymentReference($user->id);

        //creates new first mollie payment
        $mollie = new MollieService();
        $mollieData = $mollie->createNewMolliePayment($price, $description, $redirectUrl, $user->mollie_customer_id, $user, $reference);

        //checks if status is open and creates new payment in payment table
        if($mollieData['status'] == "open") {
            $paymentService = new PaymentService();
            $paymentService->createNewPayment($user, $price, $reference, "Open", $mollieData['method'], false, $mollieData['link'], $mollieData['id']);
        }
        return redirect($mollieData['link']);
    }
}