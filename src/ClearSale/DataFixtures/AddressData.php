<?php

namespace ClearSale\DataFixtures;

use ClearSale\XmlEntity\SendOrder\Address;

class AddressData
{
    public static function createAddressFixture()
    {
        $street = 'Rua José de Oliveira Coutinho';
        $number = 151;
        $county = 'Barra Funda';
        $country = 'Brasil';
        $city = 'São Paulo';
        $state = 'SP';
        $zip = '01144020';

        return Address::create($street, $number, $county, $country, $city, $state, $zip);
    }
}