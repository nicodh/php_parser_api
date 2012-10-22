<?php

abstract class PHPParser_Node_Expr_AbstractLeftRight extends PHPParser_Node_Expr {

	/**
	 * The left hand side expression
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $left;

	/**
	 * The right hand side expression
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $right;

	/**
	 * Constructs a smaller than comparison node.
	 *
	 * @param PHPParser_Node_Expr $left The left hand side expression
	 * @param PHPParser_Node_Expr $right The right hand side expression
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $left, PHPParser_Node_Expr $right, $line = -1, $ignorables = array()) {
		$this->setLeft($left);
		$this->setRight($right);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Expr $left
	 * @return \PHPParser_Node_Expr_AbstractLeftRight
	 */
	public function setLeft(PHPParser_Node_Expr $left = NULL) {
		$this->left = $left;
		$this->setSelfAsSubNodeParent($left, 'left');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr
	 */
	public function getLeft() {
		return $this->left;
	}

	/**
	 * @param \PHPParser_Node_Expr $right
	 * @return \PHPParser_Node_Expr_AbstractLeftRight
	 */
	public function setRight(PHPParser_Node_Expr $right = NULL) {
		$this->right = $right;
		$this->setSelfAsSubNodeParent($right, 'right');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr
	 */
	public function getRight() {
		return $this->right;
	}
}