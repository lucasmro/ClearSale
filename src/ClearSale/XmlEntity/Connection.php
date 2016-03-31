<?php

namespace ClearSale\XmlEntity;

use DateTime;
use XMLWriter;

class Connection implements XmlEntityInterface
{
    use FormatTrait;

    private $company;
    private $flightNumber;
    private $flightDate;
    private $class;
    private $from;
    private $to;
    private $departureDate;
    private $arrivalDate;

    public static function create($company, $flightNumber, $flightDate, $class, $from, $to, $departureDate, $arrivalDate)
    {
        $connection = new self();

        $connection
            ->setCompany($company)
            ->setFlightNumber($flightNumber)
            ->setFlightDate($flightDate)
            ->setClass($class)
            ->setFrom($from)
            ->setTo($to)
            ->setDepartureDate($departureDate)
            ->setArrivalDate($arrivalDate);

        return $connection;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    public function getFlightDate()
    {
        return $this->flightDate;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    public function setFlightNumber($flightNumber)
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    public function setFlightDate($flightDate, $isUnixTimestampFormat = false)
    {
        $this->flightDate = $this->getFormattedDate($flightDate, $isUnixTimestampFormat);

        return $this;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function setDepartureDate($departureDate, $isUnixTimestampFormat = false)
    {
        $this->departureDate = $this->getFormattedDate($departureDate, $isUnixTimestampFormat);

        return $this;
    }

    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('Connection');

        $xml->writeElement('Company', $this->company);
        $xml->writeElement('FlightNumber', $this->flightNumber);
        $xml->writeElement('FlightDate', $this->flightDate);
        $xml->writeElement('Class', $this->class);
        $xml->writeElement('From', $this->from);
        $xml->writeElement('To', $this->to);
        $xml->writeElement('DepartureDate', $this->departureDate);
        $xml->writeElement('ArrivalDate', $this->arrivalDate);

        $xml->endElement();
    }
}
