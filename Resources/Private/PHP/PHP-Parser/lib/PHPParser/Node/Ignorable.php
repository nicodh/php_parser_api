<?php

class PHPParser_Node_Ignorable extends PHPParser_NodeAbstract {

	/**
	 * Contains value
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Constructs a ignorable
	 *
	 * @param PHPParser_Node_Expr $value Value
	 * @param int $line Line
	 */
	public function __construct($value, $line = -1) {
		$this->setValue($value);
		parent::__construct($line);
	}

	/**
	 * Returns a string representation of the ignorable.
	 *
	 * @return string String representation
	 */
	public function toString() {
		return $this->value;
	}

	/**
	 * Returns a string representation of the ignorable.
	 * namespace separator.
	 *
	 * @return string String representation
	 */
	public function __toString() {
		return $this->toString();
	}

	/**
	 * @param string $value
	 * @return \PHPParser_Node_Ignorable
	 */
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

}
