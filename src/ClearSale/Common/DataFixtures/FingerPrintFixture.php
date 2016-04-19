<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\FingerPrint;

class FingerPrintFixture
{
    public static function createFingerPrint()
    {
        return new FingerPrint('session-id-1234');
    }
}
