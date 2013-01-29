<?php

/**
 * Base model class
 * 
 * The model encapsulates related data and hides the internal representation of the data
 * 
 * The model's data can be accessed via either array or object notation
 * 
 * Attemps to access non-existing properties/fields will not cause fatal error, but will return null
 * 
 * 
 */
class Model implements ArrayAccess {
	
	/**
	 * ArrayAccess interface
	 */
	public function offsetExists($property) {
		return isset($this->$property);
	}
	
	/**
	 * ArrayAccess interface
	 */
	public function offsetGet($property) {
		$getter = 'get'.  ucfirst($property);
		return $this->$getter();
	}
	
	/**
	 * ArrayAccess interface
	 */
	public function offsetSet($property, $value) {
		$setter = 'set'.  ucfirst($property);
		$this->$setter($value);
	}

	/**
	 * ArrayAccess interface
	 */
	public function offsetUnset($property) {
		unset($this->$property);
	}
	
	public function __get($property) {
		$getter = 'get'.  ucfirst($property);
		return $this->$getter();
	}
	
	public function __set($property, $value) {
		$setter = 'set'.  ucfirst($property);
		$this->$setter($value);
	}
}