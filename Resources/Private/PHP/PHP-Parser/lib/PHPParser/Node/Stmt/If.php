<?php

/**
 * @property PHPParser_Node_Expr           $cond    Condition expression
 * @property PHPParser_Node[]              $stmts   Statements
 * @property PHPParser_Node_Stmt_ElseIf[]  $elseifs Elseif clauses
 * @property null|PHPParser_Node_Stmt_Else $else    Else clause
 */
class PHPParser_Node_Stmt_If extends PHPParser_Node_Stmt {

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Contains elseifs
	 *
	 * @var PHPParser_Node_Stmt_ElseIf[]
	 */
	protected $elseifs;

	/**
	 * Contains else
	 *
	 * @var PHPParser_Node_Stmt_Else
	 */
	protected $else;

	/**
	 * Contains cond
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $cond;

	/**
	 * Constructs an if node.
	 *
	 * @param PHPParser_Node_Expr $cond Condition
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                        'stmts'   => array(): Statements
	 *                                        'elseifs' => array(): Elseif clauses
	 *                                        'else'    => null   : Else clause
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $cond, array $subNodes = array(), $line = -1, $ignorables = array()) {
		$this->setCond($cond);
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
		if (isset($subNodes['elseifs']) && NULL !== $subNodes['elseifs']) {
			$this->setElseifs($subNodes['elseifs']);
		}
		if (isset($subNodes['else']) && NULL !== $subNodes['else']) {
			$this->setElse($subNodes['else']);
		}
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Expr $cond
	 * @return \PHPParser_Node_Stmt_If
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
	 * @param PHPParser_Node_Stmt_Else $else
	 * @return \PHPParser_Node_Stmt_If
	 */
	public function setElse(PHPParser_Node_Stmt_Else $else = NULL) {
		$this->else = $else;
		$this->setSelfAsSubNodeParent($else, 'else');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Stmt_Else
	 */
	public function getElse() {
		return $this->else;
	}

	/**
	 * @param PHPParser_Node_Stmt_ElseIf $elseif
	 */
	public function appendElseif(PHPParser_Node_Stmt_ElseIf $elseif) {
		if (NULL != $this->elseifs) {
			$this->elseifs = array();
		}
		$this->elseifs[] = $elseif;
		$this->setSelfAsSubNodeParent($elseif, 'elseifs');
	}

	/**
	 * @param PHPParser_Node_Stmt_ElseIf $elseif
	 */
	public function removeElseif(PHPParser_Node_Stmt_ElseIf $elseif) {
		if (NULL !== $this->elseifs) {
			foreach ($this->elseifs as $key => $existingElseif) {
				if ($elseif === $existingElseif) {
					unset($this->elseifs[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_ElseIf $elseifNew
	 * @param PHPParser_Node_Stmt_ElseIf $elseifOld
	 */
	public function replaceElseif(PHPParser_Node_Stmt_ElseIf $elseifNew, PHPParser_Node_Stmt_ElseIf $elseifOld) {
		if (NULL !== $this->elseifs) {
			foreach ($this->elseifs as $key => $existingElseif) {
				if ($elseifOld === $existingElseif) {
					$this->elseifs[$key] = $elseifNew;
					$existingElseif->setParent();
					$this->setSelfAsSubNodeParent($elseifNew, 'elseifs');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_ElseIf[] $elseifs
	 * @return \PHPParser_Node_Stmt_If
	 */
	public function setElseifs(array $elseifs) {
		$this->elseifs = $elseifs;
		$this->setSelfAsSubNodeParent($elseifs, 'else');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_ElseIf
	 */
	public function getElseifAtIndex($index = NULL) {
		if (isset($this->elseifs[$index])) {
			return $this->elseifs[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_ElseIf[]
	 */
	public function getElseifs() {
		return $this->elseifs;
	}

	/**
	 * @stmt PHPParser_Node $stmt
	 */
	public function appendStmt(PHPParser_Node $stmt) {
		if (NULL != $this->stmts) {
			$this->stmts = array();
		}
		$this->stmts[] = $this->setSelfAsSubNodeParent($stmt, 'stmts');
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
	 * @param PHPParser_Node[] $stmts */
	public function setStmts(array $stmts) {
		$this->stmts = $this->setSelfAsSubNodeParent($stmts, 'stmts');
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