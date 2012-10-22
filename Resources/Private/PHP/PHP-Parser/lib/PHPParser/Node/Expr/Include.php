<?php

class PHPParser_Node_Expr_Include extends PHPParser_Node_Expr {

	const TYPE_INCLUDE = 1;
	const TYPE_INCLUDE_ONCE = 2;
	const TYPE_REQUIRE = 3;
	const TYPE_REQUIRE_ONCE = 4;

	/**
	 * Expression
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $expr;

	/**
	 * Type of include
	 *
	 * @var int
	 */
	protected $type;

	/**
	 * Constructs an include node.
	 *
	 * @param PHPParser_Node_Expr $expr Expression
	 * @param int $type Type of include
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $expr, $type, $line = -1, $ignorables = array()) {
		$this->setExpr($expr);
		$this->setType($type);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Expr $expr
	 * @return \PHPParser_Node_Expr_Include
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

	/**
	 * @param int $type
	 * @return \PHPParser_Node_Expr_Include
	 */
	public function setType($type) {
		$this->type = (int)$type;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getType() {
		return $this->type;
	}
}