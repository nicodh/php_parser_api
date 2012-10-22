<?php

/**
 * @property PHPParser_Node_Expr      $expr     Expression to iterate
 * @property null|PHPParser_Node_Expr $keyVar   Variable to assign key to
 * @property bool                     $byRef    Whether to assign value by reference
 * @property PHPParser_Node_Expr      $valueVar Variable to assign value to
 * @property PHPParser_Node[]         $stmts    Statements
 */
class PHPParser_Node_Stmt_Foreach extends PHPParser_Node_Stmt {

	/**
	 * Contains keyVar
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $keyVar;

	/**
	 * Contains byRef
	 *
	 * @var bool
	 */
	protected $byRef;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Contains expr
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $expr;

	/**
	 * Contains valueVar
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $valueVar;

	/**
	 * Constructs a foreach node.
	 *
	 * @param PHPParser_Node_Expr $expr Expression to iterate
	 * @param PHPParser_Node_Expr $valueVar Variable to assign value to
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                        'keyVar' => null   : Variable to assign key to
	 *                                        'byRef'  => false  : Whether to assign value by reference
	 *                                        'stmts'  => array(): Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $expr, PHPParser_Node_Expr $valueVar, array $subNodes = array(), $line = -1, $ignorables = array()) {
		$this->setExpr($expr);
		$this->setValueVar($valueVar);
		if (isset($subNodes['keyVar']) && NULL !== $subNodes['keyVar']) {
			$this->setKeyVar($subNodes['keyVar']);
		}
		if (isset($subNodes['byRef']) && NULL !== $subNodes['byRef']) {
			$this->setByRef($subNodes['byRef']);
		}
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param bool $byRef
	 * @return \PHPParser_Node_Stmt_Foreach
	 */
	public function setByRef($byRef) {
		$this->byRef = (bool)$byRef;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getByRef() {
		return $this->byRef;
	}

	/**
	 * @param PHPParser_Node_Expr $expr
	 * @return \PHPParser_Node_Stmt_Foreach
	 */
	public function setExpr(PHPParser_Node_Expr $expr = NULL) {
		$this->expr = $expr;
		$this->setSelfAsSubNodeParent($expr, 'expr');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getExpr() {
		return $this->expr;
	}

	/**
	 * @param PHPParser_Node_Expr $keyVar
	 * @return \PHPParser_Node_Stmt_Foreach
	 */
	public function setKeyVar(PHPParser_Node_Expr $keyVar = NULL) {
		$this->keyVar = $keyVar;
		$this->setSelfAsSubNodeParent($keyVar, 'keyVar');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getKeyVar() {
		return $this->keyVar;
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
	 * @return \PHPParser_Node_Stmt_Foreach
	 */
	public function setStmts(array $stmts) {
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

	/**
	 * @param PHPParser_Node_Expr $valueVar
	 * @return \PHPParser_Node_Stmt_Foreach
	 */
	public function setValueVar(PHPParser_Node_Expr $valueVar = NULL) {
		$this->valueVar = $valueVar;
		$this->setSelfAsSubNodeParent($valueVar, 'valueVar');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getValueVar() {
		return $this->valueVar;
	}
}