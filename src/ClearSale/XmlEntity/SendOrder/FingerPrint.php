<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\XmlEntity\XmlEntityInterface;
use XMLWriter;

class FingerPrint implements XmlEntityInterface
{
    private $sessionId;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement("FingerPrint");

        if ($this->sessionId) {
            $xml->writeElement("SessionID", $this->sessionId);
        }

        $xml->endElement();
    }
}
