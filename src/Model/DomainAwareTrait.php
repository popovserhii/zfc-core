<?php
/**
 * Trait for general domain methods
 *
 * @category Popov
 * @package Popov_<package>
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 06.04.15 14:07
 */

namespace Popov\ZfcCore\Model;


trait DomainAwareTrait {

	public function getProperties() {
		return get_class_vars(__CLASS__);
	}

	public function exchangeArray($data) {
		foreach ($this->getArrayCopy() as $property => $value) {
			//$value = (isset($data[$property])) ? $data[$property] : $value;
            //$this->{'set' . ucfirst($property)}($value);
            $this->{$property} = (isset($data[$property])) ? $data[$property] : $value;
		}

		return $this;
	}

	public function getArrayCopy() {
		return get_object_vars($this);
	}

	public function getObjectAsArray() {
		$array = [];
		foreach ($this->getProperties() as $propName => $default) {
			if (is_object($this->{$propName})) {
				//if (get_class($this->{$propName}) === 'Doctrine\ODM\MongoDB\PersistentCollection') {
				// @see http://stackoverflow.com/a/8915369
				$interface = 'Doctrine\Common\Collections\Collection';
				if ($this->{$propName} instanceof $interface) {
					$array[$propName] = [];
					foreach ($this->{$propName} as $obj) {
						$array[$propName][] = $obj->asArray();
					}
				} else {
					$array[$propName] = $this->{$propName}->asArray();
				}
			} else {
				$array[$propName] = $this->{$propName};
			}
		}

		//\Zend\Debug\Debug::dump($array); die(__METHOD__);
		return $array;
	}

	public function asArray() {
		return $this->getObjectAsArray();
	}

	public function toArray() {
		return $this->getObjectAsArray();
	}
}