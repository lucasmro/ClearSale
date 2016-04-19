<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\ItemFixture;
use ClearSale\XmlEntity\XmlEntityInterface;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    private $item;

    protected function setUp()
    {
        $this->item = ItemFixture::createItem();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->item = null;
    }
    public function testItem()
    {
        $this->assertSame(1, $this->item->getId());
        $this->assertSame('Adaptador USB', $this->item->getName());
        $this->assertSame(10.0, $this->item->getValue());
        $this->assertSame(1, $this->item->getQuantity());
    }

    public function testItemToXml()
    {
        $outputXML = $this->generateXML($this->item);
        $expectedXmlFile = __DIR__ . '/../../../data/item.xml';

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
