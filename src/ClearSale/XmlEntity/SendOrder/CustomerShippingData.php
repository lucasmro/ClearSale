<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\Exception\RequiredFieldException;
use ClearSale\XmlEntity\XmlEntityInterface;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

class CustomerShippingData extends AbstractCustomer
{
    /**
     * @param string $id
     * @param string $type
     * @param string $legalDocument
     * @param string $name
     * @param Address $address
     * @param Phone $phone
     * @return Customer
     */
    public static function create($id, $type, $legalDocument, $name, Address $address, $phone)
    {
        $instance = new self();

        $instance->setId($id);
        $instance->setType($type);
        $instance->setLegalDocument1($legalDocument);
        $instance->setName($name);
        $instance->setAddress($address);
        $instance->addPhone($phone);

        return $instance;
    }
}
