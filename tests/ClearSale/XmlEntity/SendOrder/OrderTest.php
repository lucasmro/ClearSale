<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\OrderFixture;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    private $ecommerceOrder;

    protected function setUp()
    {
        $this->ecommerceOrder = OrderFixture::createEcommerceOrder();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->ecommerceOrder = null;
    }

    public function testEcommerceOrderToXml()
    {
        $outputXML = $this->ecommerceOrder->toXML(true);
        $expectedXmlFile = __DIR__ . '/../../../data/order-ecommerce.xml';

        $this->assertXmlStringEqualsXmlFile($expectedXmlFile, $outputXML);
    }
}
