<?php

namespace ClearSale\Environment;

class Production extends AbstractEnvironment
{
    public function __construct($entityCode)
    {
        parent::__construct($entityCode);

        $this->application = 'https://aplicacao.clearsale.com.br/Login.aspx';
        $this->webService = 'https://integracao.clearsale.com.br/service.asmx';
    }
}
