<?php

namespace ClearSale;

class PackageStatus
{
    const STATUS_CODE_TRANSACAO_CONCLUIDA                        = '00';
    const STATUS_CODE_USUARIO_INEXISTENTE                        = '01';
    const STATUS_CODE_ERRO_VALIDACAO_XML                         = '02';
    const STATUS_CODE_ERRO_TRANFORMACAO_XML                      = '03';
    const STATUS_CODE_ERRO_INESPERADO                            = '04';
    const STATUS_CODE_PEDIDO_JA_ENVIADO_OU_NAO_ESTA_EM_REANALISE = '05';
    const STATUS_CODE_ERRO_PLUGIN_ENTRADA                        = '06';
    const STATUS_CODE_ERRO_PLUGIN_SAIDA                          = '07';

    private $transactionId;
    private $statusCode;
    private $message;
    private $order;

    public function __construct($xml)
    {
        // FIX PHP Warning: Parser error : Document labelled UTF-16 but has UTF-8 content
        $xml = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $xml);

        $object = simplexml_load_string($xml);
        // Convert SimpleXMLElement to stdClass
        $object = json_decode(json_encode($object));

        $this->setTransactionId($object->TransactionID);
        $this->setStatusCode($object->StatusCode);
        $this->setMessage($object->Message);

        if ($object->Orders) {
            $this->order = new OrderReturn(
                $object->Orders->Order->ID, $object->Orders->Order->Status, $object->Orders->Order->Score
            );
        }
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    private function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    private function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
