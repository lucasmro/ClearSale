<?php

namespace ClearSale;

use InvalidArgumentException;

abstract class ClearSaleIntegration
{
    protected $entityCode;
    protected $environment;
    protected $isDebug;
    protected $connector;

    /**
     * Construtor para gerar a integração com a ClearSale
     *
     * @param string $entityCode - Código gerado pela ClearSale
     * @param Environment $environment
     * @param bool $isDebug
     * @throws InvalidArgumentException
     */
    public function __construct($entityCode, Environment $environment, $isDebug = false)
    {
        $this->entityCode  = $entityCode;
        $this->environment = $environment;
        $this->isDebug     = $isDebug;
        $this->connector   = new ClearSaleConnector($this->getEndpoint(), $isDebug);
    }

    abstract public function getEndpoint();

    public function getEntityCode()
    {
        return $this->entityCode;
    }

    protected function setEntityCode($entityCode)
    {
        $this->entityCode = $entityCode;

        return $this;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }
}
