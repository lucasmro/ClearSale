<?php

namespace ClearSale;

use ClearSale\XmlEntity\SendOrder\Order;
use ClearSale\XmlEntity\Response\PackageStatus;

class ClearSaleService extends ClearSaleIntegration
{
    /**
     * Retorna o status de um pedido
     *
     * @param string $orderId
     */
    public function getOrderStatus($orderId)
    {
        $function   = 'GetOrderStatus';
        $parameters = array(
            'entityCode' => $this->getEnvironment()->getEntityCode(),
            'orderID'    => $orderId
        );

        $response = $this->connector->doRequest($function, $parameters);

        // TODO: Implement log -> $response->GetOrderStatusResult

        return new PackageStatus($response->GetOrderStatusResult);
    }

    /**
     * Método para envio de pedidos
     *
     * @param Order $order
     * @return PackageStatus
     */
    public function sendOrders(Order $order)
    {
        $function   = 'SendOrders';
        $parameters = array(
            'entityCode' => $this->getEnvironment()->getEntityCode(),
            'xml'        => $order->toXML($this->getEnvironment()->isDebug())
        );

        // TODO: Implement log -> $parameters['xml']

        $response = $this->connector->doRequest($function, $parameters);

        // TODO: Implement log -> $response->SendOrdersResult

        return new PackageStatus($response->SendOrdersResult);
    }

    /**
     * Método para testar se houve conexão
     *
     * @param $orderID
     * @return bool
     */
    public function getResultOrderStatus($orderID)
    {
        $function   = 'GetOrderStatus';
        $parameters = array(
            'entityCode' => $this->getEnvironment()->getEntityCode(),
            'orderID'    => $orderID
        );

        $response = $this->connector->doRequest($function, $parameters);

        $xml = $response->GetOrderStatusResult;

        // FIX PHP Warning: Parser error : Document labelled UTF-16 but has UTF-8 content
        $xml = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $xml);

        // Convert string to SimpleXMLElement
        $object = simplexml_load_string($xml);

        // Convert SimpleXMLElement to stdClass
        $object = json_decode(json_encode($object));

        return $object;

    }

}
