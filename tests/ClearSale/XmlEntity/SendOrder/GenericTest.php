<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\XmlEntity\SendOrder\Generic;
use ClearSale\XmlEntity\XmlEntityInterface;

class GenericTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Generic
     */
    private $generic;

    protected function setUp()
    {
        $this->generic = (new Generic())->setName('Teste')->setValue('17');
    }

    public function testXml()
    {
        $outputXML = $this->generateXML($this->generic);
        $expectedXmlFile = __DIR__ . '/../../../data/generic.xml';

        $this->assertXmlStringEqualsXmlFile($expectedXmlFile, $outputXML);
    }

    public function testGets()
    {
        $this->assertEquals('Teste', $this->generic->getName());
        $this->assertEquals('17', $this->generic->getValue());
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
