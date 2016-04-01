<?php

namespace ClearSale\Environment;

class Production extends AbstractEnvironment
{
    public function __construct($entityCode)
    {
        parent::__construct($entityCode);

        $this->application = 'http://aplicacao.clearsale.com.br/Login.aspx';
        $this->webService = 'http://integracao.clearsale.com.br/service.asmx';
    }
}
