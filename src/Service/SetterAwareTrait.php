<?php
namespace Popov\ZfcCore\Service;

use Zend\Stdlib\Exception;

trait SetterAwareTrait {

	public function setParameters(array $parameters, $object = null) {
		foreach ($parameters as $parameter => $value) {
			$this->setParameter($parameter, $value, $object);
		}

		return $this;
	}

	public function setParameter($parameter, $value, $object = null) {
		$object = is_object($object) ? $object : $this;
		$setter = $this->prepareMethodName($parameter);
		//$setter = 'set' . ucfirst($parameter);

		if (!method_exists($object, $setter) && !method_exists($object, $setter = lcfirst(substr($setter, 3)))) {
			throw new Exception\BadMethodCallException(sprintf(
				'Bad method call: Unknown methods %s::%s and %s::%s',
				get_class($object),
				$this->prepareMethodName($setter),
				get_class($object),
				$setter
			));
		}

		$object->{$setter}($value);

		return $this;
	}

	protected function prepareMethodName($parameter) {
		$parts = explode('_', $parameter);
		$setter = 'set';
		foreach ($parts as $part) {
			$setter .= ucfirst($part);
		}

		return $setter;
	}
}
