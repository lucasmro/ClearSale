<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\XmlEntity\SendOrder\FingerPrint;
use ClearSale\XmlEntity\XmlEntityInterface;

class FingerPrintTest extends \PHPUnit_Framework_TestCase
{
    const SESSION_ID = 'session-id-1234';

    private $fingerPrint;

    protected function setUp()
    {
        $this->fingerPrint = new FingerPrint(self::SESSION_ID);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->fingerPrint = null;
    }
    public function testFingerPrint()
    {
        $this->assertSame(self::SESSION_ID, $this->fingerPrint->getSessionId());
    }

    public function testFingerPrintToXml()
    {
        $outputXML = $this->generateXML($this->fingerPrint);
        $expectedXmlFile = __DIR__ . '/../../../data/FingerPrint.xml';

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