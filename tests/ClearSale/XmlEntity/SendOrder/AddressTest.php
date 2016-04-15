<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\AddressFixture;
use ClearSale\XmlEntity\XmlEntityInterface;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    private $address;

    protected function setUp()
    {
        $this->address = AddressFixture::createAddress();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->address = null;
    }
    public function testAddress()
    {
        $this->assertSame('Rua José de Oliveira Coutinho', $this->address->getStreet());
        $this->assertSame('151', $this->address->getNumber());
        $this->assertSame('Barra Funda', $this->address->getCounty());
        $this->assertSame('Brasil', $this->address->getCountry());
        $this->assertSame('São Paulo', $this->address->getCity());
        $this->assertSame('SP', $this->address->getState());
        $this->assertSame('01144020', $this->address->getZipCode());
    }

    public function testAddressToXml()
    {
        $outputXML = $this->generateXML($this->address);
        $expectedXmlFile = __DIR__ . '/../../../data/address.xml';

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
