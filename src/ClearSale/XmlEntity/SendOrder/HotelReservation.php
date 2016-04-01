<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\Exception\RequiredFieldException;
use ClearSale\XmlEntity\XmlEntityInterface;
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

        if ($this->hotel) {
            $xml->writeElement('Hotel', $this->hotel);
        } else {
            throw new RequiredFieldException('Field Hotel of the HotelReservation object is required');
        }

        if ($this->city) {
            $xml->writeElement('City', $this->city);
        } else {
            throw new RequiredFieldException('Field City of the HotelReservation object is required');
        }

        if ($this->state) {
            $xml->writeElement('State', $this->state);
        } else {
            throw new RequiredFieldException('Field State of the HotelReservation object is required');
        }

        if ($this->country) {
            $xml->writeElement('Country', $this->country);
        } else {
            throw new RequiredFieldException('Field Country of the HotelReservation object is required');
        }

        if ($this->reservationDate) {
            $xml->writeElement('ReservationDate', $this->reservationDate->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field ReservationDate of the HotelReservation object is required');
        }

        if ($this->reservationExpirationDate) {
            $xml->writeElement('ReservationExpirationDate',
                $this->reservationExpirationDate->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field ReservationExpirationDate of the HotelReservation object is required');
        }

        if ($this->checkInDate) {
            $xml->writeElement('CheckInDate', $this->checkInDate->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field CheckInDate of the HotelReservation object is required');
        }

        if ($this->checkOutDate) {
            $xml->writeElement('CheckOutDate', $this->checkOutDate->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field CheckOutDate of the HotelReservation object is required');
        }

        $xml->endElement();
    }
}
