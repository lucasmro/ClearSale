<?php

namespace ClearSale\DataFixtures;

use ClearSale\XmlEntity\SendOrder\FingerPrint;

class FingerPrintData
{
    public static function createFingerPrintFixture()
    {
        return new FingerPrint('session-id-1234');
    }
}