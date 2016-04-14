<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\XmlEntity\SendOrder\Phone;
use ClearSale\XmlEntity\XmlEntityInterface;

class PhoneTest extends \PHPUnit_Framework_TestCase
{
    private $phone;

    protected function setUp()
    {
        $this->phone = $this->createPhoneFixture();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->phone = null;
    }
    public function testPhone()
    {
        $this->assertSame(Phone::COMERCIAL, $this->phone->getType());
        $this->assertSame('11', $this->phone->getDDD());
        $this->assertSame('37288788', $this->phone->getNumber());
    }

    public function testPhoneToXml()
    {
        $outputXML = $this->generateXML($this->phone);
        $expectedXmlFile = __DIR__ . '/../../../data/Phone.xml';

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

    private function createPhoneFixture()
    {
        return Phone::create(Phone::COMERCIAL, '11', '37288788');
    }
}