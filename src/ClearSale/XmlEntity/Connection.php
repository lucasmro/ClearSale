<?php

namespace ClearSale\XmlEntity;

use DateTime;
use XMLWriter;

class Connection implements XmlEntityInterface
{
    /**
     *
     * @var string
     */
    private $company;

    /**
     *
     * @var string
     */
    private $flightNumber;

    /**
     *
     * @var DateTime
     */
    private $flightDate;

    /**
     *
     * @var string
     */
    private $class;

    /**
     *
     * @var string
     */
    private $from;

    /**
     *
     * @var string
     */
    private $to;

    /**
     *
     * @var DateTime
     */
    private $departureDate;

    /**
     *
     * @var DateTime
     */
    private $arrivalDate;

    public static function create($company, $flightNumber, DateTime $flightDate, $class, $from, $to, DateTime $departureDate, DateTime $arrivalDate)
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

    /**
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     *
     * @return string
     */
    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    /**
     *
     * @return DateTime
     */
    public function getFlightDate()
    {
        return $this->flightDate;
    }

    /**
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     *
     * @return DateTime
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     *
     * @return DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     *
     * @param string $company
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     *
     * @param string $flightNumber
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setFlightNumber($flightNumber)
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    /**
     *
     * @param DateTime $flightDate
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setFlightDate(DateTime $flightDate)
    {
        $this->flightDate = $flightDate;

        return $this;
    }

    /**
     *
     * @param string $class
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     *
     * @param string $from
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     *
     * @param string $to
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     *
     * @param DateTime $departureDate
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setDepartureDate(DateTime $departureDate)
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     *
     * @param DateTime $arrivalDate
     * @return \ClearSale\XmlEntity\Connection
     */
    public function setArrivalDate(DateTime $arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('Connection');

        $xml->writeElement('Company', $this->company);
        $xml->writeElement('FlightNumber', $this->flightNumber);
        $xml->writeElement('FlightDate', $this->flightDate->format(Order::DATE_TIME_FORMAT));
        $xml->writeElement('Class', $this->class);
        $xml->writeElement('From', $this->from);
        $xml->writeElement('To', $this->to);
        $xml->writeElement('DepartureDate', $this->departureDate->format(Order::DATE_TIME_FORMAT));
        $xml->writeElement('ArrivalDate', $this->arrivalDate->format(Order::DATE_TIME_FORMAT));

        $xml->endElement();
    }
}
