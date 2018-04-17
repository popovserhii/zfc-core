<?php
namespace Magere\Agere\Filter;

use Zend\Filter\AbstractFilter;

class Int extends AbstractFilter
{
	/**
	 * @param  string $value
	 * @return int|mixed
	 */
	public function filter($value)
	{
		return (int) $value;
	}
}
