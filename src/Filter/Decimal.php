<?php
namespace Magere\Agere\Filter;

use Zend\Filter\AbstractFilter;

class Decimal extends AbstractFilter
{
	/**
	 * @param  string $value
	 * @return decimal|mixed
	 */
	public function filter($value)
	{
		$value = str_replace(',', '.', $value);

		return (! empty($value) && $value != '0.00') ? number_format((float) $value, 2, '.', '') : '0.00';
	}

	/**
	 * @param float|int $value
	 * @param int $decimal
	 * @return string
	 */
	public static function filterToPhp($value, $decimal = 2)
	{
		return (! empty($value) && $value != '0.00') ? number_format((float) $value, $decimal, '.', '') : '';
	}

}
