<?php

namespace App\Http\Controllers;

use App\Payments;
use App\Services\AppServices\MailgunService;
use App\Services\AppServices\MollieService;
use App\Services\Payments\PaymentService;
use App\Services\Payments\SplitTheBillService;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
use Illuminate\Http\Request;
use App\Invoice;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{
    public function webhookMollieAction(Request $request, MailgunService $mailgunService){
        try {
            $mollie = $this->getService("mollie");
            $payment = $mollie->payments->get($request->input("id"));

            if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
                $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                $paymentTable->payment_status = "paid";
                $paymentTable->save();

                $user = User::select("*")->where("id", $paymentTable->user_id)->first();

                $team = Team::select("*")->where("id", $user->team_id)->first();
                if($team->split_the_bill == 1){
                    SplitTheBillService::acceptSplitTheBill($user);
                }

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
                $paymentTable->invoice_id = $invoice->id;
                $paymentTable->save();

                $description = $teamPackage->title . " for team " . $teamPackage->team->team_name . "-" . uniqid($user->id) . " ";

               $range = PaymentService::getPaymentRange($teamPackage);

                // no active subscriptions
                $reference = PaymentService::getPaymentReference($user->id);

                $mollie = new MollieService();
                $customer = $mollie->getCustomer($user);
                $mandates = $customer->mandates();
                if($mandates[0]->status == "valid" && $paymentTable->sub_id == null || !$user->hasValidSubscription()) {
                    $mollie->createNewMollieSubscription($user, $paymentTable->amount,$description, $reference, $range);
                }
                $subscriptions = $customer->subscriptions();
                $paymentTable->sub_id = $subscriptions[0]->id;
                $paymentTable->save();

                //Mail to Innocreation.
                $mgClient = $this->getService("mailgun");
                $mgClient[0]->sendMessage($mgClient[1], array(
                    'from' => "mitchel@innocreation.net",
                    'to' => "info@innocreation.net",
                    'subject' => "new payment!",
                    'html' => view("/templates/sendPaymentConfirmationInno", compact("user", "description"))
                ), array(
                    'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
                ));

                $mailgunService->saveAndSendEmail($user, "Congratulations for taking the next step towards your dreams!", view("/templates/sendPaymentConfirmationCustomer", compact("user", "teamPackage")));



            } elseif ($payment->isOpen()) {
                /*
                 * The payment is open.
                 */
            } elseif ($payment->isPending()) {
                /*
                 * The payment is pending.
                 */
            } elseif ($payment->isFailed()) {
                //Mail to leader

            } elseif ($payment->isExpired()) {

                try {
                    $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                    $user = User::select("*")->where("id", $paymentTable->user_id)->first();
                    $team = Team::select("*")->where("id", $user->team_id)->first();
                    if ($user->team->split_the_bill == 1) {
                        PaymentService::rejectSplitTheBillPayment($user, $team, $mailgunService);

                    } else {
                        $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                        $paymentTable->payment_status = "Expired";
                        $paymentTable->save();
                    }
                } catch (Exception $e) {
                    error_log(htmlspecialchars($e->getMessage()), 3, "/var/log/mollie/error_log.txt");
                    echo "API call failed: " . htmlspecialchars($e->getMessage());
                }

            } elseif ($payment->isCanceled()) {
                try {
                    $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                    $user = User::select("*")->where("id", $paymentTable->user_id)->first();
                    $team = Team::select("*")->where("id", $user->team_id)->first();
                    if ($user->team->split_the_bill == 1) {
                        PaymentService::rejectSplitTheBillPayment($user, $team, $mailgunService);

                    } else {
                        $paymentTable = Payments::select("*")->where("payment_id", $request->input("id"))->first();
                        $paymentTable->payment_status = "canceled";
                        $paymentTable->save();
                    }
                } catch (Exception $e) {
                    error_log(htmlspecialchars($e->getMessage()), 3, "/var/log/mollie/error_log.txt");
                    echo "API call failed: " . htmlspecialchars($e->getMessage());
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
            error_log(htmlspecialchars($e->getMessage()), 3, "/var/log/mollie/error_log.txt");
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
        return response('OK', 200);
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
