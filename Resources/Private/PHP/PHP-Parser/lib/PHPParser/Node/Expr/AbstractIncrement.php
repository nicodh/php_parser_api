<?php

abstract class PHPParser_Node_Expr_AbstractIncrement extends PHPParser_Node_Expr {

	/**
	 * Variable
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $var;

	/**
	 * Constructs a abstract increment node.
	 *
	 * @param PHPParser_Node_Expr $var Variable
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $var, $line = -1, $ignorables = array()) {
		$this->setVar($var);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Expr $var
	 * @return \PHPParser_Node_Expr_AbstractIncrement
	 */
	public function setVar(PHPParser_Node_Expr $var = NULL) {
		$this->var = $var;
		$this->setSelfAsSubNodeParent($var, 'var');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr
	 */
	public function getVar() {
		return $this->var;
	}
}