<?php

/**
 * @property PHPParser_Node_Stmt_DeclareDeclare[] $declares List of declares
 * @property PHPParser_Node[]                     $stmts    Statements
 */
class PHPParser_Node_Stmt_Declare extends PHPParser_Node_Stmt {

	/**
	 * Contains declares
	 *
	 * @var PHPParser_Node_Stmt_DeclareDeclare[]
	 */
	protected $declares;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Constructs a declare node.
	 *
	 * @param PHPParser_Node_Stmt_DeclareDeclare[] $declares List of declares
	 * @param PHPParser_Node[] $stmts Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $declares, array $stmts, $line = -1, $ignorables = array()) {
		$this->setDeclares($declares);
		$this->setStmts($stmts);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Stmt_DeclareDeclare $declare
	 */
	public function appendDeclare(PHPParser_Node_Stmt_DeclareDeclare $declare) {
		if (NULL != $this->declares) {
			$this->declares = array();
		}
		$this->declares[] = $declare;
		$this->setSelfAsSubNodeParent($declare, 'declares');
	}

	/**
	 * @param PHPParser_Node_Stmt_DeclareDeclare $declare
	 */
	public function removeDeclare(PHPParser_Node_Stmt_DeclareDeclare $declare) {
		if (NULL !== $this->declares) {
			foreach ($this->declares as $key => $existingDeclare) {
				if ($declare === $existingDeclare) {
					unset($this->declares[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_DeclareDeclare $declareNew
	 * @param PHPParser_Node_Stmt_DeclareDeclare $declareOld
	 */
	public function replaceDeclare(PHPParser_Node_Stmt_DeclareDeclare $declareNew, PHPParser_Node_Stmt_DeclareDeclare $declareOld) {
		if (NULL !== $this->declares) {
			foreach ($this->declares as $key => $existingDeclare) {
				if ($declareOld === $existingDeclare) {
					$this->declares[$key] = $declareNew;
					$existingDeclare->setParent();
					$this->setSelfAsSubNodeParent($declareNew, 'declares');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_DeclareDeclare[] $declares
	 * @return \PHPParser_Node_Stmt_Declare
	 */
	public function setDeclares(array $declares = NULL) {
		$this->declares = $declares;
		$this->setSelfAsSubNodeParent($declares, 'declares');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_DeclareDeclare
	 */
	public function getDeclareAtIndex($index = NULL) {
		if (isset($this->declares[$index])) {
			return $this->declares[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_DeclareDeclare[]
	 */
	public function getDeclares() {
		return $this->declares;
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
	 * @return \PHPParser_Node_Stmt_Declare
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