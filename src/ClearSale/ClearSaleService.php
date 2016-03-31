<?php

namespace ClearSale;

class ClearSaleService extends ClearSaleIntegration
{
    private static $endpoints = array(
        'staging'    => 'http://homologacao.clearsale.com.br/integracaov2/service.asmx',
        'production' => 'http://clearsale.com.br/integracaov2/service.asmx',
    );

    public function getEndpoint()
    {
        return self::$endpoints[$this->getEnvironment()->getType()];
    }

    /**
     * Retorna o status de um pedido
     *
     * @param string $orderId
     */
    public function getOrderStatus($orderId)
    {
        $function   = 'GetOrderStatus';
        $parameters = array(
            'entityCode' => $this->entityCode,
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
            'entityCode' => $this->entityCode,
            'xml'        => $order->toXML()
        );

        // TODO: Implement log -> $parameters['xml']

        $response = $this->connector->doRequest($function, $parameters);

        // TODO: Implement log -> $response->SendOrdersResult

        return new PackageStatus($response->SendOrdersResult);
    }
}
