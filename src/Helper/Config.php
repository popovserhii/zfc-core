<?php
/**
 * Base Config Wrapper
 *
 * @category Popov
 * @package Popov_Base
 * @author Popov Sergiy <popow.serhii@gmail.com>
 * @datetime: 02.04.15 22:46
 */
namespace Popov\ZfcCore\Helper;

use ArrayAccess;
use Countable;
use Iterator;
use Zend\Stdlib\Exception;

class Config implements Countable, Iterator, ArrayAccess {

	protected $data = [];

	/**
	 * Used when unsetting values during iteration to ensure we do not skip the next element.
	 *
	 * @var bool
	 */
	protected $skipNextIteration;

	/**
	 * Merge another array with this one.
	 *
	 * @param array $data
	 * @param string $property
	 * @return $this
	 * @throws Exception\InvalidArgumentException
	 */
	public function merge(array $data, $property = 'data') {
		if (!isset($this->{$property})) {
			throw new Exception\InvalidArgumentException("You cannot merge property {$property}. This property doesn't exist.");
		}

		//(new ArrayUtil())->merge($this->{$property}, $data);
        $this->{$property} = array_merge_recursive($this->{$property}, $data);

		return $this;
	}

	/**
	 * Set option value but not than 5 level nesting
	 *
	 * Example: path
	 *   'path' -> $options[path] = $value
	 *   'path/to' -> $options[path][to] = $value
	 *   'path/to/param' -> $options[path][to][param] = $value
	 *
	 * @param string $path
	 * @param mixed $value
	 * @return $this
	 * @throws Exception\InvalidArgumentException
	 */
	public function set($path, $value) {
		$arrayPath = $this->getArrayPath($path);
		$code = '$this->data' . $arrayPath . ' = $value;';
		eval($code);

		return $this;
	}

	/**
	 * Retrieve a value and return $default if there is no element set.
	 *
	 * @param  string $path
	 * @param  mixed $default
	 * @return mixed
	 */
	public function get($path, $default = null) {
		$arrayPath = $this->getArrayPath($path);

		$isset = false;
		eval('$isset = isset($this->data' . $arrayPath . ');');
		if ($isset) {
			eval('$default = $this->data' . $arrayPath . ';');
			return $default;
		}

		return $default;
	}

	protected function getArrayPath($path) {
		$pathPart = explode('/', $path);
		$arrayPath = '[\'' . implode('\'][\'', $pathPart) . '\']';

		return $arrayPath;
	}

	/**
	 * Return an associative array of the stored data.
	 *
	 * @return array
	 */
	public function toArray() {
		return $this->data;
	}

	/**
	 * isset() overloading
	 *
	 * @param  string $name
	 * @return bool
	 */
	public function __isset($name) {
		return isset($this->data[$name]);
	}

	/**
	 * unset() overloading
	 *
	 * @param  string $name
	 * @return void
	 * @throws Exception\InvalidArgumentException
	 */
	public function __unset($name) {
		if (isset($this->data[$name])) {
			unset($this->data[$name]);
			$this->skipNextIteration = true;
		}
	}

	/**
	 * count(): defined by Countable interface.
	 *
	 * @see    Countable::count()
	 * @return int
	 */
	public function count() {
		return count($this->data);
	}

	/**
	 * current(): defined by Iterator interface.
	 *
	 * @see    Iterator::current()
	 * @return mixed
	 */
	public function current() {
		$this->skipNextIteration = false;

		return current($this->data);
	}

	/**
	 * key(): defined by Iterator interface.
	 *
	 * @see    Iterator::key()
	 * @return mixed
	 */
	public function key() {
		return key($this->data);
	}

	/**
	 * next(): defined by Iterator interface.
	 *
	 * @see    Iterator::next()
	 * @return void
	 */
	public function next() {
		if ($this->skipNextIteration) {
			$this->skipNextIteration = false;

			return;
		}
		next($this->data);
	}

	/**
	 * rewind(): defined by Iterator interface.
	 *
	 * @see    Iterator::rewind()
	 * @return void
	 */
	public function rewind() {
		$this->skipNextIteration = false;
		reset($this->data);
	}

	/**
	 * valid(): defined by Iterator interface.
	 *
	 * @see    Iterator::valid()
	 * @return bool
	 */
	public function valid() {
		return ($this->key() !== null);
	}

	/**
	 * offsetExists(): defined by ArrayAccess interface.
	 *
	 * @see    ArrayAccess::offsetExists()
	 * @param  mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset) {
		return $this->__isset($offset);
	}

	/**
	 * offsetGet(): defined by ArrayAccess interface.
	 *
	 * @see    ArrayAccess::offsetGet()
	 * @param  mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset) {
		return $this->get($offset);
	}

	/**
	 * offsetSet(): defined by ArrayAccess interface.
	 *
	 * @see    ArrayAccess::offsetSet()
	 * @param  mixed $offset
	 * @param  mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		$this->set($offset, $value);
	}

	/**
	 * offsetUnset(): defined by ArrayAccess interface.
	 *
	 * @see    ArrayAccess::offsetUnset()
	 * @param  mixed $offset
	 * @return void
	 */
	public function offsetUnset($offset) {
		$this->__unset($offset);
	}

}