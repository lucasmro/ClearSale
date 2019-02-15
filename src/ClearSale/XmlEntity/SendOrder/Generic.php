<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\XmlEntity\XmlEntityInterface;
use XMLWriter;

class Generic implements XmlEntityInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Generic
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Generic
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param XMLWriter $xml
     */
    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('Generic');

        if ($this->name) {
            $xml->writeElement("Name", $this->name);
        }

        if (!is_null($this->value)) {
            $xml->writeElement("Value", $this->value);
        }

        $xml->endElement();
    }
}
