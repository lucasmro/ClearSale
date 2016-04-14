<?php

namespace ClearSale\DataFixtures;

use ClearSale\XmlEntity\SendOrder\Phone;

class PhoneData
{
    public static function createPhoneFixture()
    {
        return Phone::create(Phone::COMERCIAL, '11', '37288788');
    }
}