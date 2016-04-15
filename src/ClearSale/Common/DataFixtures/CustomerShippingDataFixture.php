<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\AbstractCustomer;
use ClearSale\XmlEntity\SendOrder\CustomerShippingData;

class CustomerShippingDataFixture
{
    public static function createCustomerShippingData()
    {
        $id = '1';
        $legalDocument = '63165236372';
        $name = 'Fulano da Silva';
        $address = AddressFixture::createAddress();
        $phone = PhoneFixture::createPhone();

        return CustomerShippingData::create(
            $id,
            AbstractCustomer::TYPE_PESSOA_FISICA,
            $legalDocument,
            $name,
            $address,
            $phone
        );
    }
}
