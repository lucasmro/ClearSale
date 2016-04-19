<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\FingerPrintFixture;
use ClearSale\XmlEntity\XmlEntityInterface;

class FingerPrintTest extends \PHPUnit_Framework_TestCase
{
    private $fingerPrint;

    protected function setUp()
    {
        $this->fingerPrint = FingerPrintFixture::createFingerPrint();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->fingerPrint = null;
    }
    public function testFingerPrint()
    {
        $this->assertSame('session-id-1234', $this->fingerPrint->getSessionId());
    }

    public function testFingerPrintToXml()
    {
        $outputXML = $this->generateXML($this->fingerPrint);
        $expectedXmlFile = __DIR__ . '/../../../data/fingerprint.xml';

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
