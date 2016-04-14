<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\Phone;

class PhoneFixture
{
    public static function createPhone()
    {
        return Phone::create(Phone::COMERCIAL, '11', '37288788');
    }
}