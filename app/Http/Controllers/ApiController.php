<?php

namespace App\Http\Controllers;

use App\Payments;
use App\SplitTheBillLinktable;
use App\TeamPackage;
use App\User;
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


                // no active subscriptions
                $mollie = $this->getService("mollie");
                $customer = $mollie->customers->get($user->mollie_customer_id);
                $mandates = $customer->mandates();
                if($mandates[0]->status == "valid" && $paymentTable->sub_id == null) {
                    $customer = $mollie->customers->get($user->mollie_customer_id);
                    $customer->createSubscription([
                        "amount" => [
                            "currency" => "EUR",
                            "value" => $paymentTable->amount,
                        ],
                        "interval" => "1 months",
                        "description" => $description . "recurring",
                        "webhookUrl" => "http://secret.innocreation.net/webhook/mollieRecurringPayment",
                    ]);

                }
                $subscriptions = $customer->subscriptions();
                $paymentTable->sub_id = $subscriptions[0]->id;
                $paymentTable->save();



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
        /*
         * NOTE: This example uses a text file as a database. Please use a real database like MySQL in production code.
         */
        function database_write($orderId, $status)
        {
            $orderId = intval($orderId);
            $database = dirname(__FILE__) . "/orders/order-{$orderId}.txt";
            file_put_contents($database, $status);
        }
        return response('OK', 200);
//        $response = file_get_contents('php://input');
//        $json = json_decode($response);
//        Session::set("json", $json);
    }

    public function webhookMolliePaymentAction(Request $request){

    }
}
