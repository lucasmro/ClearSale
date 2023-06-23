<?php

namespace ClearSale\Environment;

class Sandbox extends AbstractEnvironment
{
    public function __construct($entityCode)
    {
        parent::__construct($entityCode);

        $this->application = 'https://aplicacao.homologacao.clearsale.com.br/Login.aspx';
        $this->webService = 'https://homologacao.clearsale.com.br/integracaov2/Service.asmx';
    }
}
