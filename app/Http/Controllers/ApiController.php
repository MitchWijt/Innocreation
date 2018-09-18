<?php

namespace App\Http\Controllers;

use App\Payments;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
use Faker\Provider\el_CY\Payment;
use Illuminate\Http\Request;
use App\Invoice;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{
    public function webhookMollieAction(Request $request){
        try {
            $mollie = $this->getService("mollie");
            $payment = $mollie->payments->get($request->input("id"));
            $metadata = $payment->metadata->referenceAndUserId;

            if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {

                $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                $paymentTable->payment_status = "paid";
                $paymentTable->save();

                $user = User::select("*")->where("id", $paymentTable->user_id)->first();

//                }
                $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();

                $invoiceNumber = Invoice::select("*")->orderBy("invoice_number", "DESC")->first()->invoice_number;
                $invoice = new Invoice();
                $invoice->user_id = $user->id;
                $invoice->team_id = $user->team_id;
                $invoice->team_package_id = $teamPackage->id;
                $invoice->amount = number_format($teamPackage->price, 2, ".", ".");
                $invoice->hash = $user->hash;
                $invoice->invoice_number = $invoiceNumber + 1;
                $invoice->paid_date = date("Y-m-d", strtotime("+1 days"));
                $invoice->created_at = date("Y-m-d H:i:s");
                $invoice->save();

                if ($teamPackage->custom_team_package_id == null) {
                    $description = $teamPackage->title . " for team " . $teamPackage->team->team_name;
                } else {
                    $description =  " custom package for team " . $teamPackage->team->team_name;
                }

                if($teamPackage->payment_preference == "monthly"){
                    $range = "1 months";
                } else {
                    $range = "12 months";
                }

                // no active subscriptions
                $mollie = $this->getService("mollie");
                $customer = $mollie->customers->get($user->mollie_customer_id);
                $mandates = $customer->mandates();
                if($mandates[0]->status == "valid" && $paymentTable->sub_id == null || !$user->hasValidSubscription()) {
                    $customer = $mollie->customers->get($user->mollie_customer_id);
                    $customer->createSubscription([
                        "amount" => [
                            "currency" => "EUR",
                            "value" => $paymentTable->amount,
                        ],
                        "interval" => "$range",
                        "description" => $description . "recurring",
                        "startDate" => date("Y-m-d" , strtotime("+1 month")),
                        "webhookUrl" => $this->getWebhookUrl(true),
                    ]);

                }
                $subscriptions = $customer->subscriptions();
                $paymentTable->sub_id = $subscriptions[0]->id;
                $paymentTable->save();

                $mgClient = $this->getService("mailgun");
                $mgClient[0]->sendMessage($mgClient[1], array(
                    'from' => "mitchel@innocreation.net",
                    'to' => "info@innocreation.net",
                    'subject' => "new payment!",
                    'html' => view("/templates/sendPaymentConfirmationInno", compact("user", "description"))
                ), array(
                    'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
                ));



            } elseif ($payment->isOpen()) {
                /*
                 * The payment is open.
                 */
            } elseif ($payment->isPending()) {
                /*
                 * The payment is pending.
                 */
            } elseif ($payment->isFailed()) {
                $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                $paymentTable->payment_status = "failed";
                $paymentTable->save();

                //Mail to leader

            } elseif ($payment->isExpired()) {
                $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                $paymentTable->payment_status = "expired";
                $paymentTable->save();
            } elseif ($payment->isCanceled()) {

                $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                $user = User::select("*")->where("id", $paymentTable->user_id)->first();
                $mollie = $this->getService("mollie");
                if($user->team->split_the_bill == 1){
                    $splitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $user->team_id)->get();
                    foreach($splitTheBillLinktables as $splitTheBillLinktable){
                        if($splitTheBillLinktable->user->getMostRecentPayment()){
                            if($splitTheBillLinktable->user->getMostRecentPayment()->sub_id != null) {

                                $payment = $mollie->payments->get($splitTheBillLinktable->user->getMostRecentPayment()->payment_id);
                                $payment->refund([
                                    "amount" => [
                                        "currency" => "EUR",
                                        "value" => $splitTheBillLinktable->user->getMostRecentPayment()->amount // You must send the correct number of decimals, thus we enforce the use of strings
                                    ]
                                ]);

                                $recentPayment = $splitTheBillLinktable->user->getMostRecentPayment();
                                $recentPayment->payment_status = "canceled/refunded";
                                $recentPayment->sub_id = null;
                                $recentPayment->save();

                                $customer = $mollie->customers->get($splitTheBillLinktable->user->mollie_customer_id);
                                $subscriptions = $customer->subscriptions();
                                foreach ($subscriptions as $subscription) {
                                    if($subscription->status != "canceled") {
                                         $customer->cancelSubscription($subscription->id);
                                    }
                                }
                            }
                        }
                    }

                } else{
                    $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                    $paymentTable->payment_status = "canceled";
                    $paymentTable->save();
                }



                //Mail to leader

            } elseif ($payment->hasRefunds()) {
                /*
                 * The payment has been (partially) refunded.
                 * The status of the payment is still "paid"
                 */
            } elseif ($payment->hasChargebacks()) {
                /*
                 * The payment has been (partially) charged back.
                 * The status of the payment is still "paid"
                 */
            }
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
        return response('OK', 200);
//        $response = file_get_contents('php://input');
//        $json = json_decode($response);
//        Session::set("json", $json);
    }

    public function webhookMolliePaymentAction(Request $request){
        $subscriptionId = $request->input("subscriptionId");
        $paymentId = $request->input("id");
        $payment = Payments::select("*")->where("sub_id", $subscriptionId)->first();
        $payments = Payments::select("*")->orderBy("id", "DESC")->first();
        $reference = $payments->reference + 1;

        $teamPackage = TeamPackage::select("*")->where("team_id", $payment->team_id)->first();
        $team = Team::select("*")->where("id", $payment->team_id)->first();

        if($team->split_the_bill == 1){
            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $payment->user_id)->where("team_id", $payment->team_id)->first();
            $amount = $splitTheBillLinktable->amount;
        } else {
            $amount = $teamPackage->price;
        }
        $newPayment = new Payments();
        $newPayment->user_id = $payment->user_id;
        $newPayment->payment_id = $paymentId;
        $newPayment->team_id = $payment->team_id;
        $newPayment->sub_id = $subscriptionId;
        $newPayment->payment_method = "creditcard";
        $newPayment->amount = $amount;
        $newPayment->reference = $reference;
        $newPayment->payment_status = "paid";
        $newPayment->created_at = date("Y-m-d H:i:s");
        $newPayment->save();

        $teamPackage = TeamPackage::select("*")->where("team_id", $payment->team_id)->first();

        $invoiceNumber = Invoice::select("*")->orderBy("invoice_number", "DESC")->first()->invoice_number;
        $invoice = new Invoice();
        $invoice->user_id = $payment->user_id;
        $invoice->team_id = $payment->team_id;
        $invoice->team_package_id = $teamPackage->id;
        $invoice->amount = number_format($amount, 2, ".", ".");
        $invoice->hash = $payment->user->hash;
        $invoice->invoice_number = $invoiceNumber + 1;
        $invoice->paid_date = date("Y-m-d");
        $invoice->created_at = date("Y-m-d H:i:s");
        $invoice->save();

        $user = User::select("*")->where("id", $payment->user_id)->first();

        $mgClient = $this->getService("mailgun");
        $mgClient[0]->sendMessage($mgClient[1], array(
            'from' => "mitchel@innocreation.net",
            'to' => "info@innocreation.net",
            'subject' => "new payment!",
            'html' => view("/templates/sendRecurringNotificationInno", compact("user"))
        ), array(
            'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
        ));

        return response('OK', 200);
    }
}
