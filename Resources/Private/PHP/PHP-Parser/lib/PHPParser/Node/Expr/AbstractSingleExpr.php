<?php

abstract class PHPParser_Node_Expr_AbstractSingleExpr extends PHPParser_Node_Expr {

	/**
	 * Expression
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $expr;

	/**
	 * Constructs a abstract expression containing node.
	 *
	 * @param PHPParser_Node_Expr $expr Expression
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $expr, $line = -1, $ignorables = array()) {
		$this->setExpr($expr);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Expr $expr
	 * @return \PHPParser_Node_Expr_AbstractSingleExpr
	 */
	public function setExpr(PHPParser_Node_Expr $expr = NULL) {
		$this->expr = $expr;
		$this->setSelfAsSubNodeParent($expr, 'expr');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr
	 */
	public function getExpr() {
		return $this->expr;
	}
}