<?php

/**
 * @property PHPParser_Node_Name $type  Class of exception
 * @property string              $var   Variable for exception
 * @property PHPParser_Node[]    $stmts Statements
 */
class PHPParser_Node_Stmt_Catch extends PHPParser_Node_Stmt {

	/**
	 * Contains type
	 *
	 * @var PHPParser_Node_Name
	 */
	protected $type;

	/**
	 * Contains var
	 *
	 * @var string
	 */
	protected $var;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Constructs a catch node.
	 *
	 * @param PHPParser_Node_Name $type Class of exception
	 * @param string $var Variable for exception
	 * @param PHPParser_Node[] $stmts Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Name $type, $var, array $stmts = array(), $line = -1, $ignorables = array()) {
		$this->setType($type);
		$this->setVar($var);
		$this->setStmts($stmts);
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
	 * @return \PHPParser_Node_Stmt_Catch
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

	/**
	 * @param PHPParser_Node_Name $type
	 * @return \PHPParser_Node_Stmt_Catch
	 */
	public function setType(PHPParser_Node_Name $type = NULL) {
		$this->type = $type;
		$this->setSelfAsSubNodeParent($type, 'type');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Name
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $var
	 * @return \PHPParser_Node_Stmt_Catch
	 */
	public function setVar($var) {
		$this->var = (string)$var;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getVar() {
		return $this->var;
	}
}