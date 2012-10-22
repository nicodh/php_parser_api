<?php

/**
 * @property string $value String
 */
class PHPParser_Node_Stmt_InlineHTML extends PHPParser_Node_Stmt {

	/**
	 * Contains value
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Constructs an inline HTML node.
	 *
	 * @param string $value String
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($value, $line = -1, $ignorables = array()) {
		$this->setValue($value);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string $value
	 * @return \PHPParser_Node_Stmt_InlineHTML
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