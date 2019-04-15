<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 27/03/2019
 * Time: 20:39
 */

namespace App\Services\Checkout;


use App\Payments;
use App\Services\AppServices\MollieService;
use App\Services\GenericService;
use App\Services\Payments\PaymentService;
use App\Services\TimeSent;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Support\Facades\Session;

class AuthorisePaymentRequest {
    public function authorisePaymentRequest($request, $mailgunService){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();

        //Get team and teampackage + declare price
        $team = Team::select("*")->where("id", $request->input("team_id"))->first();
        $teamPackage = TeamPackage::select("*")->where("team_id", $team->id)->first();

        if($team->split_the_bill == 1){
            return self::createPaymentAndMollie(true, $team, $mailgunService, $teamPackage, $user);
        } else {
            return self::createPaymentAndMollie(false, $team, $mailgunService, $teamPackage, $user);
        }
    }


    private static function createPaymentAndMollie($split = false, $team, $mailgunService, $teamPackage, $user){
        $reference =  $reference = PaymentService::getPaymentReference($user->id);

        $priceAndDescription = self::priceAndDescription($team, $teamPackage, $user, $reference);
        $loggedInUser = $user;
        $price = $priceAndDescription['price'];
        $description = $priceAndDescription['description'];
        $redirectUrl = $priceAndDescription['redirectUrl'];

        if($split){
            $splitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $team->id)->get();
            foreach ($splitTheBillLinktables as $splitTheBillLinktable) {
                $user = User::select("*")->where("id", $splitTheBillLinktable->user_id)->first();
                $mailgunService->saveAndSendEmail($splitTheBillLinktable->user, $team->team_name . " wants to split the bill!", view("/templates/sendSplitTheBillNotification", compact("user", "team")));

                $timeSent = new TimeSent();
                $userChat = UserChat::select("*")->where("receiver_user_id", $splitTheBillLinktable->user_id)->where("creator_user_id", 1)->first();
                $userMessage = new UserMessage();
                $userMessage->sender_user_id = 1;
                $userMessage->user_chat_id = $userChat->id;
                $userMessage->time_sent = $timeSent->time;
                $userMessage->message = "$team->team_name has chosen to split the bill with you and your members! Verify the request at payment details in your account to benefit from the package even quicker!";
                $userMessage->created_at = date("Y-m-d H:i:s");
                $userMessage->save();

                $mollie = new MollieService();
                $mollieData = $mollie->createNewMolliePayment($price, $description, $redirectUrl, $splitTheBillLinktable->user->mollie_customer_id, $user, $reference);
                if($mollieData['status'] == "open") {
                    $payment = new Payments();
                    $payment->user_id = $splitTheBillLinktable->user->id;
                    $payment->team_id = $team->id;
                    $payment->payment_id = $mollieData['id'];
                    $payment->payment_url = $mollieData['link'];
                    $payment->payment_method = $mollieData['method'];
                    $payment->amount = $price;
                    $payment->reference = $reference;
                    $payment->payment_status = "Open";
                    $payment->created_at = date("Y-m-d H:i:s");
                    $payment->save();
                }
            }
            $linktableUser = SplitTheBillLinktable::select("*")->where("user_id", $loggedInUser->id)->where("team_id", $team->id)->first();
            return redirect($linktableUser->getPaymentUrl());
        } else {
            $mollie = new MollieService();
            $mollieData = $mollie->createNewMolliePayment($price, $description, $redirectUrl, $user->mollie_customer_id, $user, $reference);
            if($mollieData['status'] == "open") {
                $payment = new Payments();
                $payment->user_id = $team->users->id;
                $payment->team_id = $team->id;
                $payment->payment_id = $mollieData['id'];
                $payment->payment_url = $mollieData['link'];
                $payment->payment_method = $mollieData['method'];
                $payment->amount = $price;
                $payment->reference = $reference;
                $payment->payment_status = "Open";
                $payment->created_at = date("Y-m-d H:i:s");
                $payment->save();
            }
            return redirect($mollieData['link']);
        }
    }

    public static function redirectUrl($split = false, $user){
        $fullDomain = $_SERVER['HTTP_HOST'];
        $domainExplode = explode(".", $fullDomain);

        if($domainExplode[0] == "secret") {
            $host = "http://secret.innocreation.net";
        } else {
            $host = "http://innocreation.net";
        }

        if($split){
            if($user->id == $user->team->ceo_user_id) {
                $url = '/my-team/payment-details';
            } else {
                $url = "/almost-there";
            }
        } else {
            $url = "/thank-you";
        }
        return $host . $url;

    }

    private static function priceAndDescription($team, $teamPackage, $user, $reference){
        if ($team->split_the_bill == 0) {
            $redirectUrl = self::redirectUrl(false, $user);
            $description = $teamPackage->title . " for team " . $team->team_name . "-" . $reference;
            $price = number_format($teamPackage->price, 2, ".", ".");
        } else {
            $redirectUrl = self::redirectUrl(true, $user);

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("team_id", $team->id)->where("user_id", $user->id)->first();
            $splitTheBillLinktable->accepted = 1;
            $splitTheBillLinktable->save();

            $price = number_format($splitTheBillLinktable->amount, 2, ".", ".");
            $description = $teamPackage->title . " for team " . $team->team_name . "split the bill";
        }

        return ['redirectUrl' => $redirectUrl, 'description' => $description, 'price' => $price];
    }
}