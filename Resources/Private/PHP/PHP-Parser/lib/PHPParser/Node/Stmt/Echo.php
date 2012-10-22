<?php

/**
 * @property PHPParser_Node_Expr[] $exprs Expressions
 */
class PHPParser_Node_Stmt_Echo extends PHPParser_Node_Stmt {

	/**
	 * Contains exprs
	 *
	 * @var PHPParser_Node_Expr[]
	 */
	protected $exprs;

	/**
	 * Constructs an echo node.
	 *
	 * @param PHPParser_Node_Expr[] $exprs Expressions
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $exprs, $line = -1, $ignorables = array()) {
		$this->setExprs($exprs);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Expr $expr
	 */
	public function appendExpr(PHPParser_Node_Expr $expr) {
		if (NULL != $this->exprs) {
			$this->exprs = array();
		}
		$this->exprs[] = $expr;
		$this->setSelfAsSubNodeParent($expr, 'exprs');
	}

	/**
	 * @param PHPParser_Node_Expr $expr
	 */
	public function removeExpr(PHPParser_Node_Expr $expr) {
		if (NULL !== $this->exprs) {
			foreach ($this->exprs as $key => $existingExpr) {
				if ($expr === $existingExpr) {
					unset($this->exprs[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr $exprNew
	 * @param PHPParser_Node_Expr $exprOld
	 */
	public function replaceExpr(PHPParser_Node_Expr $exprNew, PHPParser_Node_Expr $exprOld) {
		if (NULL !== $this->exprs) {
			foreach ($this->exprs as $key => $existingExpr) {
				if ($exprOld === $existingExpr) {
					$this->exprs[$key] = $exprNew;
					$existingExpr->setParent();
					$this->setSelfAsSubNodeParent($exprNew, 'exprs');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr[] $exprs
	 * @return \PHPParser_Node_Stmt_Echo
	 */
	public function setExprs(array $exprs = NULL) {
		$this->exprs = $exprs;
		$this->setSelfAsSubNodeParent($exprs, 'exprs');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getExprAtIndex($index = NULL) {
		if (isset($this->exprs[$index])) {
			return $this->exprs[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr[]
	 */
	public function getExprs() {
		return $this->exprs;
	}
}