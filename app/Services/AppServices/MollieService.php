<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 06/03/2019
     * Time: 18:39
     */

    namespace App\Services\AppServices;


    use Mollie\Api\MollieApiClient;

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
    }