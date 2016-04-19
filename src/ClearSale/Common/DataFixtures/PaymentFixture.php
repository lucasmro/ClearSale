<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\Payment;

class PaymentFixture
{
    public static function createPayment()
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2016-04-13 23:39:07');

        return Payment::create(Payment::BOLETO_BANCARIO, $date, 17.5);
    }
}
