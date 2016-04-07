<?php

namespace ClearSale;

use ClearSale\Environment\AbstractEnvironment;
use SoapClient;

class ClearSaleConnector
{
    private $client;
    private $environment;

    public function __construct(AbstractEnvironment $environment)
    {
        $this->environment = $environment;
        $this->client   = new SoapClient($this->environment->getWebService() . '?WSDL');
    }

    public function doRequest($function, $parameters)
    {
        $arguments = array($function => $parameters);
        $options   = array('location' => $this->environment->getWebService());

        if ($this->environment->isDebug()) {
            // TODO: Implement log
        }

        $response = $this->client->__soapCall($function, $arguments, $options);

        if ($this->environment->isDebug()) {
            // TODO: Implement log
        }

        return $response;
    }
}
