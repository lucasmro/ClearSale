<?php

namespace ClearSale\XmlEntity;

use ClearSale\Exception\RequiredFieldException;
use InvalidArgumentException;
use XMLWriter;

class Phone implements XmlEntityInterface
{
    const NAO_DEFINIDO = 0;
    const RESIDENCIAL  = 1;
    const COMERCIAL    = 2;
    const RECADOS      = 3;
    const COBRANCA     = 4;
    const TEMPORARIO   = 5;
    const CELULAR      = 6;

    private static $types = array(
        self::NAO_DEFINIDO,
        self::RESIDENCIAL,
        self::COMERCIAL,
        self::RECADOS,
        self::COBRANCA,
        self::TEMPORARIO,
        self::CELULAR,
    );
    private $ddi;
    private $ddd;
    private $number;
    private $extension;
    private $type;

    public function __construct()
    {

    }

    public static function create($type, $ddd, $number)
    {
        $instance = new self();

        $instance->setType($type);
        $instance->setDDD($ddd);
        $instance->setNumber($number);

        return $instance;
    }

    public function getDDI()
    {
        return $this->ddi;
    }

    public function setDDI($ddi)
    {
        $ddi = preg_replace('/[^0-9]/', '', $ddi);

        if (strlen($ddi) < 1 || strlen($ddi) > 3) {
            throw new InvalidArgumentException(sprintf('Invalid DDI', $ddi));
        }

        $this->ddi = $ddi;

        return $this;
    }

    public function getDDD()
    {
        return $this->ddd;
    }

    public function setDDD($ddd)
    {
        $ddd = preg_replace('/[^0-9]/', '', $ddd);

        if (strlen($ddd) != 2) {
            throw new InvalidArgumentException(sprintf('Invalid DDD', $ddd));
        }

        $this->ddd = $ddd;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (strlen($number) != 9 && strlen($number) != 8) {
            throw new InvalidArgumentException(sprintf('Invalid Number', $number));
        }

        $this->number = $number;

        return $this;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!array_key_exists($type, self::$types)) {
            throw new InvalidArgumentException(sprintf('Invalid type (%s)', $type));
        }

        $this->type = $type;

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement("Phone");

        if ($this->type) {
            $xml->writeElement("Type", $this->type);
        } else {
            throw new RequiredFieldException('Field Type of the Phone object is required');
        }

        if ($this->ddi) {
            $xml->writeElement("DDI", $this->ddi);
        }

        if ($this->ddd) {
            $xml->writeElement("DDD", $this->ddd);
        } else {
            throw new RequiredFieldException('Field DDD of the Phone object is required');
        }

        if ($this->number) {
            $xml->writeElement("Number", $this->number);
        } else {
            throw new RequiredFieldException('Field Number of the Phone object is required');
        }

        if ($this->extension) {
            $xml->writeElement("Extension", $this->extension);
        }

        $xml->endElement();
    }
}
