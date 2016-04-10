<?php

namespace ClearSale\Test\Environment;

use ClearSale\Environment\Production;

class ProductionTest extends \PHPUnit_Framework_TestCase
{
    const ENTITY_CODE = 'ENTITY-CODE';
    const WEBSERVICE_URL = 'http://integracao.clearsale.com.br/service.asmx';
    const APPLICATION_URL = 'http://aplicacao.clearsale.com.br/Login.aspx';

    private $environment;

    protected function setUp()
    {
        $this->environment = new Production(self::ENTITY_CODE);
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
