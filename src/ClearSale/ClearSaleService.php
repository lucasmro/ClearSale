<?php

namespace ClearSale;

use ClearSale\XmlEntity\Order;

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
            'xml'        => $order->toXML()
        );

        // TODO: Implement log -> $parameters['xml']

        $response = $this->connector->doRequest($function, $parameters);

        // TODO: Implement log -> $response->SendOrdersResult

        return new PackageStatus($response->SendOrdersResult);
    }
}
