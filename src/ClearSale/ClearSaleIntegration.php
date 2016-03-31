<?php

namespace ClearSale;

use ClearSale\Environment\AbstractEnvironment;
use InvalidArgumentException;

abstract class ClearSaleIntegration
{
    protected $environment;
    protected $connector;

    /**
     * Construtor para gerar a integração com a ClearSale
     *
     * @param AbstractEnvironment $environment
     * @throws InvalidArgumentException
     */
    public function __construct(AbstractEnvironment $environment)
    {
        $this->environment = $environment;
        $this->connector   = new ClearSaleConnector($environment);
    }

    /**
     *
     * @return AbstractEnvironment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
