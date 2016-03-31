<?php

namespace ClearSale;

use InvalidArgumentException;
use XMLWriter;

class Address
{
    private $street;
    private $number;
    private $complement;
    private $county;
    private $city;
    private $state;
    private $country;
    private $zipCode;
    private $reference;

    public function __construct()
    {

    }

    public static function create($street, $number, $county, $country, $city, $state, $zipCode)
    {
        $instance = new self();

        $instance->setStreet($street);
        $instance->setNumber($number);
        $instance->setCounty($county);
        $instance->setCountry($country);
        $instance->setCity($city);
        $instance->setState($state);
        $instance->setZipCode($zipCode);

        return $instance;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        if (empty($street)) {
            throw new InvalidArgumentException('Street is empty!');
        }

        $this->street = $street;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (empty($number)) {
            throw new InvalidArgumentException('Number is empty!');
        }

        $this->number = $number;

        return $this;
    }

    public function getComplement()
    {
        return $this->complement;
    }

    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    public function getCounty()
    {
        return $this->county;
    }

    public function setCounty($county)
    {
        if (empty($county)) {
            throw new InvalidArgumentException('County is empty!');
        }

        $this->county = $county;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        if (empty($city)) {
            throw new InvalidArgumentException('City is empty!');
        }

        $this->city = $city;

        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        if (empty($state)) {
            throw new InvalidArgumentException('State is empty!');
        }

        $this->state = $state;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        if (empty($country)) {
            throw new InvalidArgumentException('Country is empty!');
        }

        $this->country = $country;

        return $this;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode($zipCode)
    {
        $zipCode = preg_replace('/[^0-9]/', '', $zipCode);

        if (empty($zipCode)) {
            throw new InvalidArgumentException('ZipCode is empty!');
        }

        $this->zipCode = $zipCode;

        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement("Address");

        if ($this->street) {
            $xml->writeElement("Street", $this->street);
        }

        if ($this->number) {
            $xml->writeElement("Number", $this->number);
        }

        if ($this->complement) {
            $xml->writeElement("Comp", $this->complement);
        }

        if ($this->county) {
            $xml->writeElement("County", $this->county);
        }

        if ($this->city) {
            $xml->writeElement("City", $this->city);
        }

        if ($this->state) {
            $xml->writeElement("State", $this->state);
        }

        if ($this->country) {
            $xml->writeElement("Country", $this->country);
        }

        if ($this->zipCode) {
            $xml->writeElement("ZipCode", $this->zipCode);
        }

        if ($this->reference) {
            $xml->writeElement("Reference", $this->reference);
        }

        $xml->endElement();
    }
}
