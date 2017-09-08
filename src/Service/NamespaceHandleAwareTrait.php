<?php
namespace Popov\ZfcCore\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Exception;

trait NamespaceHandleAwareTrait {

	public function getDelimeterPosition($name, $delimeter) {
		static $cache;
		if (!$name || !$delimeter) {
			return false;
		}
		if (!isset($cache[$name])) {
			$delimeterPos = strpos($name, $delimeter);
			if (false === $delimeterPos) {
				$cache[$name] = false;
			} else {
				$cache[$name] = $delimeterPos;
			}
		}

		return $cache[$name];
	}

	public function moduleExist(ServiceLocatorInterface $sm, $module) {
		static $modules;
		if (!$modules) {
			$manager = $sm->get('ModuleManager');
			$modules = $manager->getLoadedModules();
		}

		return isset($modules[$module]);
	}

	/**
	 * Parse namespace like string
	 *
	 * Example:
	 * 	$delimeter = 'Routine'
	 * 	$suffix = 'Service\Plugin'
	 * 	WebApp\Routine\Create ->
	 * 		package 	=> Popov
	 * 		package 	=> WebApp
	 * 		suffix 		=> Service\Plugin
	 * 		delimeter 	=> Routine
	 * 		name 		=> Create
	 *
	 * 	$delimeter = 'Routine'
	 * 	$suffix = ''
	 * 	WebApp\Routine\Create ->
	 * 		package 	=> Popov
	 * 		package 	=> WebApp
	 * 		suffix 		=> ''
	 * 		delimeter 	=> Routine
	 * 		name 		=> Create
	 *
	 *  $delimeter = 'Routine'
	 * 	$suffix = ''
	 * 	Popov\WebApp\Service\Plugin\Routine\Create ->
	 * 		package 	=> Popov
	 * 		package 	=> WebApp
	 * 		suffix 		=> Service\Plugin
	 * 		delimeter 	=> Routine
	 * 		name 		=> Create
	 *
	 * @param ServiceLocatorInterface $sm
	 * @param $requestedName
	 * @param $delimeter
	 * @param string $suffix
	 * @return array
	 * @throws Exception\RuntimeException
	 */
	public function parseName(ServiceLocatorInterface $sm, $requestedName, $delimeter, $suffix = '') {
		$parts = array_map('ucfirst', explode('\\', $requestedName));
		if (!isset($parts[0])) {
			throw new Exception\RuntimeException(sprintf('Requested name is empty'));
		}

		$nameParts = [
			'package'   => '',
			'module'    => '',
			'suffix'    => $suffix,
			'delimeter' => $delimeter,
			'name'      => '',
		];

		if ($this->moduleExist($sm, $parts[0])) {
			$nameParts['module'] = $parts[0];
			$nameParts['name'] = implode('\\', array_slice($parts, 1));
		} elseif (isset($parts[1]) && $this->moduleExist($sm, $parts[0] . '\\' . $parts[1])) {
			$nameParts['package'] = $parts[0];
			$nameParts['module'] = $parts[1];
			$nameParts['name'] = (!isset($parts[2])) ? $parts[1] : implode('\\', array_slice($parts, 2));
		} elseif ($this->moduleExist($sm, $module = 'Popov\\' . $parts[0])) {
			$nameParts['package'] = 'Popov';
			$nameParts['module'] = $parts[0];
			$nameParts['name'] = (!isset($parts[1])) ? $parts[0] : implode('\\', array_slice($parts, 1));
		} else {
			throw new Exception\RuntimeException(sprintf('Module %s not found', $module));
		}

		if (false !== ($delimeterPos = $this->getDelimeterPosition($nameParts['name'], $delimeter))) {
			if (!$nameParts['suffix']) {
				$nameParts['suffix'] = substr($nameParts['name'], 0, ($delimeterPos - 1));
			}
			$nameParts['name'] = substr($nameParts['name'], $delimeterPos + (strlen($delimeter) + 1));
		} elseif ((false !== ($suffixPos = $this->getDelimeterPosition($nameParts['name'], $suffix)))) {
			$nameParts['name'] = substr($nameParts['name'], $suffixPos + (strlen($suffix) + 1));
		}

		return $nameParts;
	}

	public function prepareName(ServiceLocatorInterface $sm, $name, $delimeter, $suffix = '') {
		return $this->prepareParsedName($this->parseName($sm, $name, $delimeter, $suffix));
	}

	public function prepareParsedName(array $parsedName) {
		return implode('\\', array_filter($parsedName));
	}

}
