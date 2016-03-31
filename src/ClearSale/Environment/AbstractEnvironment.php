<?php

namespace ClearSale\Environment;

abstract class AbstractEnvironment
{
    protected $entityCode;
    protected $webService;
    protected $application;
    protected $debug = false;

    public function __construct($entityCode)
    {
        $this->entityCode = $entityCode;
    }

    public function getEntityCode()
    {
        return $this->entityCode;
    }

    public function getWebService()
    {
        return $this->webService;
    }

    public function getApplication()
    {
        return $this->application;
    }

    public function isDebug()
    {
        return (bool)$this->debug;
    }

    public function setDebug($debug = true)
    {
        $this->debug = $debug;

        return $this;
    }
}
