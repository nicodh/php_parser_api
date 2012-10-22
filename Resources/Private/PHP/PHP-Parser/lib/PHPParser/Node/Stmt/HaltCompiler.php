<?php

/**
 * @property string $remaining Remaining text after halt compiler statement.
 */
class PHPParser_Node_Stmt_HaltCompiler extends PHPParser_Node_Stmt {

	/**
	 * Contains remaining
	 *
	 * @var string
	 */
	protected $remaining;

	/**
	 * Constructs a __halt_compiler node.
	 *
	 * @param string $remaining Remaining text after halt compiler statement.
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($remaining, $line = -1, $ignorables = array()) {
		$this->setRemaining($remaining);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string $remaining
	 * @return \PHPParser_Node_Stmt_HaltCompiler
	 */
	public function setRemaining($remaining) {
		$this->remaining = $remaining;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRemaining() {
		return $this->remaining;
	}
}