<?php

namespace ClearSale;

class ClearSaleConnector
{
    private $client;
    private $endpoint;
    private $isDebug;

    public function __construct($endpoint, $isDebug = false) {
        $this->endpoint = $endpoint;
        $this->isDebug = $isDebug;
        $this->client = new \SoapClient($this->endpoint . '?WSDL');
    }

    public function doRequest($function, $parameters) {
        $arguments = array($function => $parameters);
        $options = array('location' => $this->endpoint);

        if ($this->isDebug) {
            // TODO: Implement log
        }

        $response = $this->client->__soapCall($function, $arguments, $options);

        if ($this->isDebug) {
            // TODO: Implement log
        }

        return $response;
    }
}
