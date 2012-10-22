<?php

class PHPParser_Node_Expr_Instanceof extends PHPParser_Node_Expr {

	/**
	 * Expression
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $expr;

	/**
	 * Class name
	 *
	 * @var PHPParser_Node_Name|PHPParser_Node_Expr
	 */
	protected $class;

	/**
	 * Constructs an instanceof check node.
	 *
	 * @param PHPParser_Node_Expr $expr Expression
	 * @param PHPParser_Node_Name|PHPParser_Node_Expr $class Class name
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $expr, $class, $line = -1, $ignorables = array()) {
		$this->setExpr($expr);
		$this->setClass($class);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Expr|\PHPParser_Node_Name $class
	 * @return \PHPParser_Node_Expr_Instanceof
	 */
	public function setClass($class = NULL) {
		if (NULL !== $class && !$class instanceof PHPParser_Node_Expr && !$class instanceof PHPParser_Node_Name) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' expects $type to be either PHPParser_Node_Expr or PHPParser_Node_Name. ' . gettype($class) . ' given.', 1337629100);
		}
		$this->class = $class;
		$this->setSelfAsSubNodeParent($class, 'class');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr|\PHPParser_Node_Name
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @param \PHPParser_Node_Expr $expr
	 * @return \PHPParser_Node_Expr_Instanceof
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