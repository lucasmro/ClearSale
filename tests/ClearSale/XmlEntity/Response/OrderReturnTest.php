<?php

namespace ClearSale\Test\XmlEntity\Response;

use ClearSale\XmlEntity\Response\OrderReturn;

class OrderReturnTest extends \PHPUnit_Framework_TestCase
{
    private $orderReturn;

    protected function tearDown()
    {
        parent::tearDown();

        $this->orderReturn = null;
    }

    public function testOrderReturnIdAndScore()
    {
        $id = '123';
        $score = 43.100;

        $this->orderReturn = new OrderReturn(
            $id,
            OrderReturn::STATUS_SAIDA_APROVACAO_AUTOMATICA,
            43.100
        );

        $this->assertSame($id, $this->orderReturn->getId());
        $this->assertSame($score, $this->orderReturn->getScore());
    }

    /**
     * @dataProvider statusProvider
     */
    public function testOrderReturnStatus($status, $expectedStatus)
    {
        $this->orderReturn = new OrderReturn(
            '123',
            $status,
            43.100
        );

        $this->assertSame($expectedStatus, $this->orderReturn->getStatus());
    }

    public function statusProvider()
    {
        return array(
            array('APA', OrderReturn::STATUS_SAIDA_APROVACAO_AUTOMATICA),
            array('APM', OrderReturn::STATUS_SAIDA_APROVACAO_MANUAL),
            array('RPM', OrderReturn::STATUS_SAIDA_REPROVADA_SEM_SUSPEITA),
            array('AMA', OrderReturn::STATUS_SAIDA_ANALISE_MANUAL),
            array('ERR', OrderReturn::STATUS_SAIDA_ERRO),
            array('NVO', OrderReturn::STATUS_SAIDA_NOVO),
            array('SUS', OrderReturn::STATUS_SAIDA_SUSPENSAO_MANUAL),
            array('CAN', OrderReturn::STATUS_SAIDA_CANCELADO_PELO_CLIENTE),
            array('FRD', OrderReturn::STATUS_SAIDA_FRAUDE_CONFIRMADA),
            array('RPA', OrderReturn::STATUS_SAIDA_REPROVACAO_AUTOMATICA),
            array('RPP', OrderReturn::STATUS_SAIDA_REPROVACAO_POR_POLITICA),
        );
    }
}
