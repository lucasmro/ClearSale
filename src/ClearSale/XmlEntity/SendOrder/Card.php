<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\XmlEntity\XmlEntityInterface;
use InvalidArgumentException;
use XMLWriter;

class Card implements XmlEntityInterface
{
    const DINERS           = 1;
    const MASTERCARD       = 2;
    const VISA             = 3;
    const OUTROS           = 4;
    const AMERICAN_EXPRESS = 5;
    const HIPERCARD        = 6;
    const AURA             = 7;

    private static $cards = array(
        self::DINERS,
        self::MASTERCARD,
        self::VISA,
        self::OUTROS,
        self::AMERICAN_EXPRESS,
        self::HIPERCARD,
        self::AURA,
    );
    private $type;
    private $name;
    private $number;
    private $securityCode;
    private $expirationDate;
    private $bin;

    public function __construct()
    {

    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!in_array($type, self::$cards)) {
            throw new InvalidArgumentException(sprintf('Invalid type (%s)', $type));
        }

        $this->type = $type;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;

        return $this;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getBin()
    {
        return $this->bin;
    }

    public function setBin($bin)
    {
        $this->bin = $bin;

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        if ($this->number) {
            $xml->writeElement("CardNumber", $this->number);
        }

        if ($this->bin) {
            $xml->writeElement("CardBin", $this->bin);
        }

        if ($this->securityCode) {
            $xml->writeElement("CardEndNumber", $this->securityCode);
        }

        if ($this->type) {
            $xml->writeElement("CardType", $this->type);
        }

        if ($this->expirationDate) {
            $xml->writeElement("CardExpirationDate", $this->expirationDate);
        }

        if ($this->name) {
            $xml->writeElement("Name", $this->name);
        }
    }
}
