<?php

namespace ClearSale\XmlEntity;

use DateTime;
use XMLWriter;

class HotelReservation implements XmlEntityInterface
{
    /**
     *
     * @var string
     */
    private $hotel;

    /**
     *
     * @var string
     */
    private $city;

    /**
     *
     * @var string
     */
    private $state;

    /**
     *
     * @var string
     */
    private $country;

    /**
     *
     * @var DateTime
     */
    private $reservationDate;

    /**
     *
     * @var DateTime
     */
    private $reservationExpirationDate;

    /**
     *
     * @var DateTime
     */
    private $checkInDate;

    /**
     *
     * @var DateTime
     */
    private $checkOutDate;

    /**
     *
     * @return string
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @return DateTime
     */
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    /**
     *
     * @return DateTime
     */
    public function getReservationExpirationDate()
    {
        return $this->reservationExpirationDate;
    }

    /**
     *
     * @return DateTime
     */
    public function getCheckInDate()
    {
        return $this->checkInDate;
    }

    /**
     *
     * @return DateTime
     */
    public function getCheckOutDate()
    {
        return $this->checkOutDate;
    }

    public function setHotel($hotel)
    {
        $this->hotel = $hotel;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function setReservationDate(DateTime $reservationDate)
    {
        $this->reservationDate = $reservationDate;
        return $this;
    }

    public function setReservationExpirationDate(DateTime $reservationExpirationDate)
    {
        $this->reservationExpirationDate = $reservationExpirationDate;
        return $this;
    }

    public function setCheckInDate(DateTime $checkInDate)
    {
        $this->checkInDate = $checkInDate;
        return $this;
    }

    public function setCheckOutDate(DateTime $checkOutDate)
    {
        $this->checkOutDate = $checkOutDate;
        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('HotelReservation');

        $xml->writeElement('Hotel', $this->hotel);
        $xml->writeElement('City', $this->city);
        $xml->writeElement('State', $this->state);
        $xml->writeElement('Country', $this->country);
        $xml->writeElement('ReservationDate', $this->reservationDate->format(Order::DATE_TIME_FORMAT));
        $xml->writeElement('ReservationExpirationDate', $this->reservationExpirationDate->format(Order::DATE_TIME_FORMAT));
        $xml->writeElement('CheckInDate', $this->checkInDate->format(Order::DATE_TIME_FORMAT));
        $xml->writeElement('CheckOutDate', $this->checkOutDate->format(Order::DATE_TIME_FORMAT));

        $xml->endElement();
    }
}
