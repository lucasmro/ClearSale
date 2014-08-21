<?php

namespace ClearSale;

class Environment
{
    const STAGING = 'staging';
    const PRODUCTION = 'production';

    private static $environments = array(
        self::STAGING,
        self::PRODUCTION,
    );

    private $type;

    public function __construct($environment)
    {
        if (!in_array($environment, self::$environments)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid environment (%s)', $environment)
            );
        }

        $this->type = $environment;
    }

    public function getType() {
        return $this->type;
    }
}
