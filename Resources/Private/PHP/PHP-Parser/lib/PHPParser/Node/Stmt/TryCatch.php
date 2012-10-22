<?php

/**
 * @property PHPParser_Node[]            $stmts   Statements
 * @property PHPParser_Node_Stmt_Catch[] $catches Catches
 */
class PHPParser_Node_Stmt_TryCatch extends PHPParser_Node_Stmt {

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Contains catches
	 *
	 * @var PHPParser_Node_Stmt_Catch[]
	 */
	protected $catches;

	/**
	 * Constructs a try catch node.
	 *
	 * @param PHPParser_Node[] $stmts Statements
	 * @param PHPParser_Node_Stmt_Catch[] $catches Catches
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $stmts, array $catches, $line = -1, $ignorables = array()) {
		$this->setStmts($stmts);
		$this->setCatches($catches);
		parent::__construct($line, $ignorables);
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
	 * @return \PHPParser_Node_Stmt_TryCatch
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
	 * @param PHPParser_Node_Stmt_Catch $catch
	 */
	public function appendCatch(PHPParser_Node_Stmt_Catch $catch) {
		if (NULL != $this->catches) {
			$this->catches = array();
		}
		$this->catches[] = $catch;
		$this->setSelfAsSubNodeParent($catch, 'catches');
	}

	/**
	 * @param PHPParser_Node_Stmt_Catch $catch
	 */
	public function removeCatch(PHPParser_Node_Stmt_Catch $catch) {
		if (NULL !== $this->catches) {
			foreach ($this->catches as $key => $existingCatche) {
				if ($catch === $existingCatche) {
					unset($this->catches[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_Catch $catchNew
	 * @param PHPParser_Node_Stmt_Catch $catchOld
	 */
	public function replaceCatch(PHPParser_Node_Stmt_Catch $catchNew, PHPParser_Node_Stmt_Catch $catchOld) {
		if (NULL !== $this->catches) {
			foreach ($this->catches as $key => $existingCatche) {
				if ($catchOld === $existingCatche) {
					$this->catches[$key] = $catchNew;
					$existingCatche->setParent();
					$this->setSelfAsSubNodeParent($catchNew, 'catches');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_Catch[] $catches
	 * @return \PHPParser_Node_Stmt_TryCatch
	 */
	public function setCatches(array $catches) {
		$this->catches = $catches;
		$this->setSelfAsSubNodeParent($catches, 'catches');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_Catch
	 */
	public function getCatcheAtIndex($index = NULL) {
		if (isset($this->catches[$index])) {
			return $this->catches[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_Catch[]
	 */
	public function getCatches() {
		return $this->catches;
	}
}