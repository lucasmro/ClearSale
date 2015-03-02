<?php

namespace ClearSale\Type;

class Currency
{

	const BRL = 986;
	const EUR = 978;
	const USD = 840;

	private $_currency;

	public function __construct($currency)
	{
		// Get the const names for validation
		$selfClass = new ReflectionClass ( __CLASS__ );
		$constants = $selfClass->getConstants();
		$constNames = array();
		foreach ( $constants as $name => $value )
		{
			$constNames[$name] = $value;
		}


		// Check if the currency is a valid string
		if (!is_numeric($currency) && array_key_exists($currency, $constNames))
		{
			$currency = $constNames[$currency];
		}

		// Check if the currency is valid
		if (!in_array($currency, $constNames))
		{
			throw new \InvalidArgumentException(
				sprintf('Invalid currency (%s)', $currency)
			);
		}

		$this->_currency = $currency;
	}

	/**
	 * Return the Currency value
	 *
	 * @return int
	 */
	public function toValue()
	{
		return $this->_currency;
	}

}
