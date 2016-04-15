<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\Order;

class OrderFixture
{
    public static function createEcommerceOrder()
    {
        $fingerPrint = FingerPrintFixture::createFingerPrint();
        $customerBillingData = CustomerBillingDataFixture::createCustomerBillingData();
        $customerShippingData = CustomerShippingDataFixture::createCustomerShippingData();
        $item = ItemFixture::createItem();
        $payment = PaymentFixture::createPayment();

        $orderId = 'TEST-b8e8eb55423b73e2e8e6bf42961aebbb';
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2016-04-13 23:39:07');
        $email = 'cliente@clearsale.com.br';
        $totalItems = 10.0;
        $totalOrder = 17.5;
        $quantityInstallments = 1;
        $ip = '127.0.0.1';
        $origin = 'WEB';

        return Order::createEcommerceOrder(
            $fingerPrint,
            $orderId,
            $date,
            $email,
            $totalItems,
            $totalOrder,
            $quantityInstallments,
            $ip,
            $origin,
            $customerBillingData,
            $customerShippingData,
            $payment,
            $item
        );
    }
}
