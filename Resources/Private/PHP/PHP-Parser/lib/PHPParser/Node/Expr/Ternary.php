<?php

class PHPParser_Node_Expr_Ternary extends PHPParser_Node_Expr {

	/**
	 * Contains cond
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $cond;

	/**
	 * Contains if
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $if;

	/**
	 * Contains else
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $else;

	/**
	 * Constructs a ternary operator node.
	 *
	 * @param PHPParser_Node_Expr $cond Condition
	 * @param null|PHPParser_Node_Expr $if Expression for true
	 * @param PHPParser_Node_Expr $else Expression for false
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $cond, $if, PHPParser_Node_Expr $else, $line = -1, $ignorables = array()) {
		$this->setCond($cond);
		if (NULL !== $if) {
			$this->setIf($if);
		}
		$this->setElse($else);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Expr $cond
	 * @return \PHPParser_Node_Expr_Ternary
	 */
	public function setCond(PHPParser_Node_Expr $cond = NULL) {
		$this->cond = $cond;
		$this->setSelfAsSubNodeParent($cond, 'cond');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getCond() {
		return $this->cond;
	}

	/**
	 * @param PHPParser_Node_Expr $else
	 * @return \PHPParser_Node_Expr_Ternary
	 */
	public function setElse(PHPParser_Node_Expr $else = NULL) {
		$this->else = $else;
		$this->setSelfAsSubNodeParent($else, 'else');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getElse() {
		return $this->else;
	}

	/**
	 * @param PHPParser_Node_Expr $if
	 * @return \PHPParser_Node_Expr_Ternary
	 */
	public function setIf(PHPParser_Node_Expr $if = NULL) {
		$this->if = $if;
		$this->setSelfAsSubNodeParent($if, 'if');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getIf() {
		return $this->if;
	}
}