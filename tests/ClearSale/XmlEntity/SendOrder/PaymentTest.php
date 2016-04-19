<?php

namespace ClearSale\Test\XmlEntity\SendOrder;

use ClearSale\Common\DataFixtures\PaymentFixture;
use ClearSale\XmlEntity\SendOrder\Payment;
use ClearSale\XmlEntity\XmlEntityInterface;

class PaymentTest extends \PHPUnit_Framework_TestCase
{
    private $payment;

    protected function setUp()
    {
        $this->payment = PaymentFixture::createPayment();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->payment = null;
    }
    public function testPayment()
    {
        $this->assertInstanceOf('\DateTime', $this->payment->getDate());
        $this->assertSame(17.5, $this->payment->getAmount());
        $this->assertSame(Payment::BOLETO_BANCARIO, $this->payment->getType());
    }

    public function testPaymentToXml()
    {
        $outputXML = $this->generateXML($this->payment);
        $expectedXmlFile = __DIR__ . '/../../../data/payment.xml';

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
