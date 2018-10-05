<?php

namespace ClearSale\XmlEntity\Response;

class PackageStatus
{
    const STATUS_CODE_TRANSACAO_CONCLUIDA = '00';
    const STATUS_CODE_USUARIO_INEXISTENTE = '01';
    const STATUS_CODE_ERRO_VALIDACAO_XML = '02';
    const STATUS_CODE_ERRO_TRANFORMACAO_XML = '03';
    const STATUS_CODE_ERRO_INESPERADO = '04';
    const STATUS_CODE_PEDIDO_JA_ENVIADO_OU_NAO_ESTA_EM_REANALISE = '05';
    const STATUS_CODE_ERRO_PLUGIN_ENTRADA = '06';
    const STATUS_CODE_ERRO_PLUGIN_SAIDA = '07';

    private static $statusCodeExceptions = array(
        self::STATUS_CODE_USUARIO_INEXISTENTE => 'ClearSale\Exception\UserNotFoundException',
        self::STATUS_CODE_ERRO_VALIDACAO_XML => 'ClearSale\Exception\XmlValidationException',
        self::STATUS_CODE_ERRO_TRANFORMACAO_XML => 'ClearSale\Exception\XmlTransformException',
        self::STATUS_CODE_ERRO_INESPERADO => 'ClearSale\Exception\UnexpectedErrorException',
        self::STATUS_CODE_PEDIDO_JA_ENVIADO_OU_NAO_ESTA_EM_REANALISE => 'ClearSale\Exception\OrderAlreadySentNotReanalysingException',
        self::STATUS_CODE_ERRO_PLUGIN_ENTRADA => 'ClearSale\Exception\InputPluginException',
        self::STATUS_CODE_ERRO_PLUGIN_SAIDA => 'ClearSale\Exception\OutputPluginException'
    );

    private $transactionId;
    private $statusCode;
    private $message;
    private $order;

    public function __construct($xml)
    {
        // FIX PHP Warning: Parser error : Document labelled UTF-16 but has UTF-8 content
        $xml = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $xml);

        // Convert string to SimpleXMLElement
        $object = simplexml_load_string($xml);
		
        // Convert SimpleXMLElement to stdClass
        $object = json_decode(json_encode($object));

        if (isset($object->StatusCode)) {
            $this->setTransactionId($object->TransactionID);
            $this->setStatusCode($object->StatusCode);
            $this->setMessage($object->Message);

            $this->validateStatusCode();
        }

        if (isset($object->Orders)) {
            $this->order = new OrderReturn(
                $object->Orders->Order->ID,
                $object->Orders->Order->Status,
                !is_object($object->Orders->Order->Score) ? $object->Orders->Order->Score : ''
            );
        }
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getOrder()
    {
        return $this->order;
    }

    private function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    private function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    private function setMessage($message)
    {
        $this->message = trim($message);

        return $this;
    }

    private function validateStatusCode()
    {
        if (self::STATUS_CODE_TRANSACAO_CONCLUIDA === $this->getStatusCode()) {
            return;
        }

        if (self::STATUS_CODE_USUARIO_INEXISTENTE === $this->getStatusCode()) {
            $this->setMessage('User with the entity code given not found');
        }

        $exceptionClass = static::$statusCodeExceptions[$this->getStatusCode()];

        throw new $exceptionClass($this->getMessage(), $this->getStatusCode());
    }
}
