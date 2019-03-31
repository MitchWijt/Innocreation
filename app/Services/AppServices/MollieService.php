<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 06/03/2019
     * Time: 18:39
     */

    namespace App\Services\AppServices;


    use App\Services\GenericService;
    use App\Services\Payments\PaymentService;
    use App\User;
    use Mollie\Api\MollieApiClient;
    use phpDocumentor\Reflection\DocBlock\Tags\Generic;

    class MollieService {
        private $mollie;

        public function __construct() {
            $mollie = new MollieApiClient();
            $mollie->setApiKey(env("MOLLIE_API"));
            $this->mollie = $mollie;
        }

        public function generateNewCustomer($user){
            $customer = $this->mollie->customers->create([
                "name" => $user->getName(),
                "email" => $user->email,
            ]);

            return $customer;
        }

        public function getCustomer($user){
            $mollie = $this->mollie;
            $customer = $mollie->customers->get($user->mollie_customer_id);
            return $customer;

        }

        public function changePackageOfCustomer($team, $price){
            $user = User::select("*")->where("id", $team->ceo_user_id)->first();
            $mollie = $this->mollie;
            $sub = $user->getMostRecentPayment();
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $subscription = $customer->getSubscription($sub->sub_id);
            $subscription->amount = (object) [
                "currency" => "EUR",
                "value" => number_format($price, 2, ".", "."),
            ];
            $subscription->webhookUrl = PaymentService::getWebhookUrlMollie(true);
            $subscription->startDate = date("Y-m-d", strtotime("+1 month"));
            $subscription->update();
        }

        public function createNewMolliePayment($price, $description, $redirectUrl, $mollieCustomerId, $user, $reference){
            $mollie = $this->mollie;
            $paymentMollie = $mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $price
                ],
                "description" => $description,
                "redirectUrl" => $redirectUrl,
                "webhookUrl" => PaymentService::getWebhookUrlMollie(),
                "method" => "creditcard",
                "sequenceType" => "first",
                "customerId" => $mollieCustomerId,
                "metadata" => [
                    "referenceAndUserId" => $reference,
                ],
            ]);

            return ['status' => $paymentMollie->status, 'id' => $paymentMollie->id, 'link' => $paymentMollie->_links->checkout->href, 'method' => $paymentMollie->method];
        }

        public function createNewMollieSubscription($user, $price, $description, $reference, $range){
            $mollie = $this->mollie;
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $customer->createSubscription([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $price,
                ],
                "interval" => "$range",
                "description" => $description . $reference . "recurring",
                "webhookUrl" => PaymentService::getWebhookUrlMollie(true),
            ]);
        }

        public function refundPayment($paymentId, $price){
            $priceString = number_format($price, 2, ".", ",");
            $mollie = $this->mollie;
            $payment = $mollie->payments->get($paymentId);
            $payment->refund([
                "amount" => [
                    "currency" => "EUR",
                    "value" => "$priceString" // You must send the correct number of decimals, thus we enforce the use of strings
                ]
            ]);
        }

        public function cancelAllSubscriptions($user){
            $mollie = $this->mollie;
            $customer = $mollie->customers->get($user->mollie_customer_id);
            $subscriptions = $customer->subscriptions();
            foreach ($subscriptions as $subscription) {
                if($subscription->status != "canceled") {
                    $customer->cancelSubscription($subscription->id);
                }
            }
        }
    }