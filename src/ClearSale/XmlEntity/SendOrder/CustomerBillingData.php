<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\Exception\RequiredFieldException;
use ClearSale\XmlEntity\XmlEntityInterface;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

class CustomerBillingData extends AbstractCustomer
{
    /**
     * @param string $id
     * @param string $type
     * @param string $legalDocument
     * @param string $name
     * @param Address $address
     * @param Phone $phone
     * @param DateTime $birthDate
     * @return Customer
     */
    public static function create($id, $type, $legalDocument, $name, Address $address, $phone, DateTime $birthDate)
    {
        $instance = new self();

        $instance->setId($id);
        $instance->setType($type);
        $instance->setLegalDocument1($legalDocument);
        $instance->setName($name);
        $instance->setAddress($address);
        $instance->addPhone($phone);
        $instance->setBirthDate($birthDate);

        return $instance;
    }

    public function toXML(XMLWriter $xml)
    {
        parent::toXML($xml);

        if ($this->birthDate) {
            $xml->writeElement("BirthDate", $this->birthDate->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field BirthDate of the CustomerBillingData object is required');
        }
    }
}
