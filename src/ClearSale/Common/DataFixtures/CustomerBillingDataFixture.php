<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\AbstractCustomer;
use ClearSale\XmlEntity\SendOrder\CustomerBillingData;

class CustomerBillingDataFixture
{
    public static function createCustomerBillingData()
    {
        $id = '1';
        $legalDocument = '63165236372';
        $name = 'Fulano da Silva';
        $address = AddressFixture::createAddress();
        $phone = PhoneFixture::createPhone();
        $birthDate = new \DateTime('1980-01-01');

        return CustomerBillingData::create(
            $id,
            AbstractCustomer::TYPE_PESSOA_FISICA,
            $legalDocument,
            $name,
            $address,
            $phone,
            $birthDate
        );
    }
}