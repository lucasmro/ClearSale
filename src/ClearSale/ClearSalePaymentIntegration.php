<?php

namespace ClearSale;

class ClearSalePaymentIntegration extends ClearSaleIntegration
{
    private static $endpoints = array(
        'staging' => 'http://homologacao.clearsale.com.br/integracaov2/paymentintegration.asmx',
        'production' => 'http://www.clearsale.com.br/integracaov2/paymentintegration.asmx',
    );

    public function getEndpoint()
    {
        return self::$endpoints[$this->getEnvironment()->getType()];
    }

    /**
     * Método que atualiza o status do pedido para o status recebido no parametro statusPedido
     *
     * @param string $orderId
     * @param string $statusPedido
     * @return
     */
    public function updateOrderStatusId($orderId, $statusPedido)
    {
        $function = 'UpdateOrderStatusID';
        $parameters = array(
            'entityCode' => $this->entityCode,
            'orderID' => $orderId,
            'statusPedido' => $statusPedido,
        );

        $response = $this->connector->doRequest($function, $parameters);

        // FIX PHP Warning: Parser error : Document labelled UTF-16 but has UTF-8 content
        $xml = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $response->UpdateOrderStatusIDResult);

        $object = simplexml_load_string($xml);

        $orderReturn = new OrderReturn(
            $object->ID,
            $object->Status,
            $object->Score
        );

        return $orderReturn;
    }
}
