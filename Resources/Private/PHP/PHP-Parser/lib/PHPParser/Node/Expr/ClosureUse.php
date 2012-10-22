<?php

class PHPParser_Node_Expr_ClosureUse extends PHPParser_Node_Expr {

	/**
	 * Contains Name of variable
	 *
	 * @var string
	 */
	protected $var;

	/**
	 * Whether to use by reference
	 *
	 * @var bool
	 */
	protected $byRef = FALSE;

	/**
	 * Constructs a closure use node.
	 *
	 * @param string $var Name of variable
	 * @param bool $byRef Whether to use by reference
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct($var, $byRef = FALSE, $line = -1, $ignorables = array()) {
		$this->setVar($var);
		$this->setByRef($byRef);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param boolean $byRef
	 * @return \PHPParser_Node_Expr_ClosureUse
	 */
	public function setByRef($byRef) {
		$this->byRef = (bool)$byRef;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getByRef() {
		return $this->byRef;
	}

	/**
	 * @param string $var
	 * @return \PHPParser_Node_Expr_ClosureUse
	 */
	public function setVar($var) {
		$this->var = (string)$var;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getVar() {
		return $this->var;
	}
}