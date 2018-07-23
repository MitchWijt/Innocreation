<?php

namespace Adyen\Service\ResourceModel\Checkout;

class Payments extends \Adyen\Service\AbstractResource
{

    protected $_endpoint;

    public function __construct($service)
    {
        $this->_endpoint = $service->getClient()->getConfig()->get('endpointCheckout') .'/'. $service->getClient()->getApiCheckoutVersion() . '/payments';
        parent::__construct($service, $this->_endpoint);
    }

}
