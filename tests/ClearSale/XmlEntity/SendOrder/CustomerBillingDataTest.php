<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\CustomerBillingDataFixture;
use ClearSale\XmlEntity\SendOrder\AbstractCustomer;
use ClearSale\XmlEntity\XmlEntityInterface;

class CustomerBillingDataTest extends \PHPUnit_Framework_TestCase
{
    private $customer;

    protected function setUp()
    {
        $this->customer = CustomerBillingDataFixture::createCustomerBillingData();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->customer = null;
    }
    public function testCustomerBillingData()
    {
        $phones = $this->customer->getPhones();
        $phone = $phones[0];

        $this->assertSame('1', $this->customer->getId());
        $this->assertSame(AbstractCustomer::TYPE_PESSOA_FISICA, $this->customer->getType());
        $this->assertSame('Fulano da Silva', $this->customer->getName());
        $this->assertInstanceOf('ClearSale\XmlEntity\SendOrder\Address', $this->customer->getAddress());
        $this->assertInstanceOf('ClearSale\XmlEntity\SendOrder\Phone', $phone);
        $this->assertInstanceOf('\DateTime', $this->customer->getBirthDate());
    }
    
    public function testCustomerBillingDataToXml()
    {
        $outputXML = $this->generateXML($this->customer);
        $expectedXmlFile = __DIR__ . '/../../../data/customer-billing-data.xml';

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
