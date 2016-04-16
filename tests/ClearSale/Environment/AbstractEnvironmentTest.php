<?php

namespace ClearSale\Test\Environment;

class AbstractEnvironmentTest extends \PHPUnit_Framework_TestCase
{
    private $environment;

    protected function setUp()
    {
        parent::setUp();

        $this->environment = $this->getMockBuilder('ClearSale\Environment\AbstractEnvironment')
            ->disableOriginalConstructor()
            ->setMethods(array('getEntityCode', 'getWebService', 'getApplication', 'isDebug'))
            ->getMockForAbstractClass();

        $this->environment->expects($this->any())
            ->method('getEntityCode')
            ->will($this->returnValue('EC-123456'));

        $this->environment->expects($this->any())
            ->method('getWebService')
            ->will($this->returnValue('http://localhost/service.asmx'));

        $this->environment->expects($this->any())
            ->method('getApplication')
            ->will($this->returnValue('http://localhost/login.aspx'));

        $this->environment->expects($this->any())
            ->method('isDebug')
            ->will($this->returnValue(true));
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->environment = null;
    }

    public function testEntityCode()
    {
        $this->assertSame('EC-123456', $this->environment->getEntityCode());
    }

    public function testWebServiceUrl()
    {
        $this->assertSame('http://localhost/service.asmx', $this->environment->getWebService());
    }

    public function testApplicationUrl()
    {
        $this->assertSame('http://localhost/login.aspx', $this->environment->getApplication());
    }

    public function testIsDebugTrue()
    {
        $this->assertTrue($this->environment->isDebug());
    }
}
