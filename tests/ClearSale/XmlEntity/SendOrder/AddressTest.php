<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\XmlEntity\SendOrder\Address;
use ClearSale\XmlEntity\XmlEntityInterface;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    private $address;

    protected function setUp()
    {
        $this->address = $this->createAddressFixture();
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
        $expectedXmlFile = __DIR__ . '/../../../data/Address.xml';

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

    private function createAddressFixture()
    {
        $street = 'Rua José de Oliveira Coutinho';
        $number = 151;
        $county = 'Barra Funda';
        $country = 'Brasil';
        $city = 'São Paulo';
        $state = 'SP';
        $zip = '01144020';

        return Address::create($street, $number, $county, $country, $city, $state, $zip);
    }
}