<?php

namespace ClearSale\Test\Environment;

use ClearSale\Environment\Sandbox;

class SandboxTest extends \PHPUnit_Framework_TestCase
{
    const ENTITY_CODE = 'ENTITY-CODE';
    const WEBSERVICE_URL = 'http://homologacao.clearsale.com.br/integracaov2/Service.asmx';
    const APPLICATION_URL = 'http://aplicacao.homologacao.clearsale.com.br/Login.aspx';

    private $environment;

    protected function setUp()
    {
        $this->environment = new Sandbox(self::ENTITY_CODE);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->environment = null;
    }

    public function testEntityCode()
    {
        $this->assertSame(self::ENTITY_CODE, $this->environment->getEntityCode());
    }

    public function testWebServiceUrl()
    {
        $this->assertSame(self::WEBSERVICE_URL, $this->environment->getWebService());
    }

    public function testApplicationUrl()
    {
        $this->assertSame(self::APPLICATION_URL, $this->environment->getApplication());
    }

    public function testDebug()
    {
        $this->assertFalse($this->environment->isDebug());
    }

    public function testDebugTrue()
    {
        $this->environment->setDebug(true);

        $this->assertTrue($this->environment->isDebug());
    }
}
