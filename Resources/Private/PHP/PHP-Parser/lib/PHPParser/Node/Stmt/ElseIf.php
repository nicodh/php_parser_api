<?php

class PHPParser_Node_Stmt_ElseIf extends PHPParser_Node_Stmt {

	/**
	 * Contains cond
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $cond;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Constructs an elseif node.
	 *
	 * @param PHPParser_Node_Expr $cond Condition
	 * @param PHPParser_Node[] $stmts Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $cond, array $stmts = array(), $line = -1, $ignorables = array()) {
		$this->setCond($cond);
		$this->setStmts($stmts);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Expr $cond
	 * @return \PHPParser_Node_Stmt_ElseIf
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
	 * @stmt PHPParser_Node $stmt
	 */
	public function appendStmt(PHPParser_Node $stmt) {
		if (NULL != $this->stmts) {
			$this->stmts = array();
		}
		$this->stmts[] = $stmt;
		$this->setSelfAsSubNodeParent($stmt, 'stmts');
	}

	/**
	 * @stmt PHPParser_Node $stmt
	 */
	public function removeStmt(PHPParser_Node $stmt) {
		if (NULL !== $this->stmts) {
			foreach ($this->stmts as $key => $existingStmt) {
				if ($stmt === $existingStmt) {
					unset($this->stmts[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @stmt PHPParser_Node $stmtNew
	 * @stmt PHPParser_Node $stmtOld
	 */
	public function replaceStmt(PHPParser_Node $stmtNew, PHPParser_Node $stmtOld) {
		if (NULL !== $this->stmts) {
			foreach ($this->stmts as $key => $existingStmt) {
				if ($stmtOld === $existingStmt) {
					$this->stmts[$key] = $stmtNew;
					$existingStmt->setParent();
					$this->setSelfAsSubNodeParent($stmtNew, 'stmts');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node[] $stmts
	 * @return \PHPParser_Node_Stmt_ElseIf
	 */
	public function setStmts(array $stmts = NULL) {
		$this->stmts = $stmts;
		$this->setSelfAsSubNodeParent($stmts, 'stmts');
		return $this;
	}


	/**
	 * @return PHPParser_Node
	 */
	public function getStmtAtIndex($index = NULL) {
		if (isset($this->stmts[$index])) {
			return $this->stmts[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node[]
	 */
	public function getStmts() {
		return $this->stmts;
	}
}