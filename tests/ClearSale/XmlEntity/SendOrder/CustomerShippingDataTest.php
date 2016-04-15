<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\CustomerShippingDataFixture;
use ClearSale\XmlEntity\SendOrder\AbstractCustomer;
use ClearSale\XmlEntity\XmlEntityInterface;

class CustomerShippingDataTest extends \PHPUnit_Framework_TestCase
{
    private $customer;

    protected function setUp()
    {
        $this->customer = CustomerShippingDataFixture::createCustomerShippingData();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->customer = null;
    }
    public function testCustomerShippingData()
    {
        $phone = $this->customer->getPhones()[0];

        $this->assertSame('1', $this->customer->getId());
        $this->assertSame(AbstractCustomer::TYPE_PESSOA_FISICA, $this->customer->getType());
        $this->assertSame('Fulano da Silva', $this->customer->getName());
        $this->assertInstanceOf('ClearSale\XmlEntity\SendOrder\Address', $this->customer->getAddress());
        $this->assertInstanceOf('ClearSale\XmlEntity\SendOrder\Phone', $phone);
    }

    public function testCustomerShippingDataToXml()
    {
        $outputXML = $this->generateXML($this->customer);
        $expectedXmlFile = __DIR__ . '/../../../data/customer-shipping-data.xml';

        $this->assertXmlStringEqualsXmlFile($expectedXmlFile, $outputXML);
    }

    private function generateXML(XmlEntityInterface $xmlEntity)
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->setIndent(false);

        $xmlEntity->toXML($xmlWriter);

        return $xmlWriter->outputMemory(true);
    }
}
