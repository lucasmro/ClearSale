<?php

namespace ClearSale\XmlEntity;

use XMLWriter;

class HotelReservation implements XmlEntityInterface
{
    use FormatTrait;

    private $hotel;
    private $city;
    private $state;
    private $country;
    private $reservationDate;
    private $reservationExpirationDate;
    private $checkInDate;
    private $checkOutDate;

    public function getHotel()
    {
        return $this->hotel;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    public function getReservationExpirationDate()
    {
        return $this->reservationExpirationDate;
    }

    public function getCheckInDate()
    {
        return $this->checkInDate;
    }

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

    public function setReservationDate($reservationDate, $isUnixTimestampFormat = false)
    {
        $this->reservationDate = $this->getFormattedDate($reservationDate, $isUnixTimestampFormat);
        return $this;
    }

    public function setReservationExpirationDate($reservationExpirationDate, $isUnixTimestampFormat = false)
    {
        $this->reservationExpirationDate = $this->getFormattedDate($reservationExpirationDate, $isUnixTimestampFormat);
        return $this;
    }

    public function setCheckInDate($checkInDate, $isUnixTimestampFormat = false)
    {
        $this->checkInDate = $this->getFormattedDate($checkInDate, $isUnixTimestampFormat);
        return $this;
    }

    public function setCheckOutDate($checkOutDate, $isUnixTimestampFormat = false)
    {
        $this->checkOutDate = $this->getFormattedDate($checkOutDate, $isUnixTimestampFormat);
        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('HotelReservation');

        $xml->writeElement('Hotel', $this->hotel);
        $xml->writeElement('City', $this->city);
        $xml->writeElement('State', $this->state);
        $xml->writeElement('Country', $this->country);
        $xml->writeElement('ReservationDate', $this->reservationDate);
        $xml->writeElement('ReservationExpirationDate', $this->reservationExpirationDate);
        $xml->writeElement('CheckInDate', $this->checkInDate);
        $xml->writeElement('CheckOutDate', $this->checkOutDate);

        $xml->endElement();
    }
}
