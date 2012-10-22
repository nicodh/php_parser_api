<?php

/**
 * @property PHPParser_Node_Expr[] $init  Init expressions
 * @property PHPParser_Node_Expr[] $cond  Loop conditions
 * @property PHPParser_Node_Expr[] $loop  Loop expressions
 * @property PHPParser_Node[]      $stmts Statements
 */
class PHPParser_Node_Stmt_For extends PHPParser_Node_Stmt {

	/**
	 * Contains init
	 *
	 * @var PHPParser_Node_Expr[]
	 */
	protected $init;

	/**
	 * Contains cond
	 *
	 * @var PHPParser_Node_Expr[]
	 */
	protected $cond;

	/**
	 * Contains loop
	 *
	 * @var PHPParser_Node_Expr[]
	 */
	protected $loop;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Constructs a for loop node.
	 *
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                'init'  => array(): Init expressions
	 *                                'cond'  => array(): Loop conditions
	 *                                'loop'  => array(): Loop expressions
	 *                                'stmts' => array(): Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $subNodes = array(), $line = -1, $ignorables = array()) {
		if (isset($subNodes['init']) && NULL !== $subNodes['init']) {
			$this->setInit($subNodes['init']);
		}
		if (isset($subNodes['cond']) && NULL !== $subNodes['cond']) {
			$this->setCond($subNodes['cond']);
		}
		if (isset($subNodes['loop']) && NULL !== $subNodes['loop']) {
			$this->setLoop($subNodes['loop']);
		}
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
		parent::__construct($line, $ignorables);
	}

	/**
	 * @cond PHPParser_Node_Expr $cond
	 */
	public function appendCond(PHPParser_Node_Expr $cond) {
		if (!is_array($this->cond)) {
			$this->cond = array();
		}
		$this->cond[] = $cond;
		$this->setSelfAsSubNodeParent($cond, 'cond');
	}

	/**
	 * @cond PHPParser_Node_Expr $cond
	 */
	public function removeCond(PHPParser_Node_Expr $cond) {
		if (!is_array($this->cond)) {
			foreach ($this->cond as $key => $existingCond) {
				if ($cond === $existingCond) {
					unset($this->cond[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @cond PHPParser_Node_Expr $condNew
	 * @cond PHPParser_Node_Expr $condOld
	 */
	public function replaceCond(PHPParser_Node_Expr $condNew, PHPParser_Node_Expr $condOld) {
		if (!is_array($this->cond)) {
			foreach ($this->cond as $key => $existingCond) {
				if ($condOld === $existingCond) {
					$this->cond[$key] = $condNew;
					$existingCond->setParent();
					$this->setSelfAsSubNodeParent($condNew, 'cond');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr[] $cond
	 * @return \PHPParser_Node_Stmt_For
	 */
	public function setCond(array $cond = NULL) {
		$this->cond = $cond;
		$this->setSelfAsSubNodeParent($cond, 'cond');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getCondExprAtIndex($index = NULL) {
		if (isset($this->loop[$index])) {
			return $this->loop[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr[]
	 */
	public function getCond() {
		return $this->cond;
	}

	/**
	 * @init PHPParser_Node_Expr $init
	 */
	public function appendInit(PHPParser_Node_Expr $init) {
		if (!is_array($this->init)) {
			$this->init = array();
		}
		$this->init[] = $init;
		$this->setSelfAsSubNodeParent($init, 'init');
	}

	/**
	 * @init PHPParser_Node_Expr $init
	 */
	public function removeInit(PHPParser_Node_Expr $init) {
		if (!is_array($this->init)) {
			foreach ($this->init as $key => $existingInit) {
				if ($init === $existingInit) {
					unset($this->init[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @init PHPParser_Node_Expr $initNew
	 * @init PHPParser_Node_Expr $initOld
	 */
	public function replaceInit(PHPParser_Node_Expr $initNew, PHPParser_Node_Expr $initOld) {
		if (!is_array($this->init)) {
			foreach ($this->init as $key => $existingInit) {
				if ($initOld === $existingInit) {
					$this->init[$key] = $initNew;
					$existingInit->setParent();
					$this->setSelfAsSubNodeParent($initNew, 'init');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr[] $init
	 * @return \PHPParser_Node_Stmt_For
	 */
	public function setInit(array $init = NULL) {
		$this->init = $init;
		$this->setSelfAsSubNodeParent($init, 'init');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getInitExprAtIndex($index = NULL) {
		if (isset($this->init[$index])) {
			return $this->init[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr[]
	 */
	public function getInit() {
		return $this->init;
	}

	/**
	 * @loop PHPParser_Node_Expr $loop
	 */
	public function appendLoop(PHPParser_Node_Expr $loop) {
		if (!is_array($this->loop)) {
			$this->loop = array();
		}
		$this->loop[] = $loop;
		$this->setSelfAsSubNodeParent($loop, 'loop');
	}

	/**
	 * @loop PHPParser_Node_Expr $loop
	 */
	public function removeLoop(PHPParser_Node_Expr $loop) {
		if (!is_array($this->loop)) {
			foreach ($this->loop as $key => $existingLoop) {
				if ($loop === $existingLoop) {
					unset($this->loop[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @loop PHPParser_Node_Expr $loopNew
	 * @loop PHPParser_Node_Expr $loopOld
	 */
	public function replaceLoop(PHPParser_Node_Expr $loopNew, PHPParser_Node_Expr $loopOld) {
		if (!is_array($this->loop)) {
			foreach ($this->loop as $key => $existingLoop) {
				if ($loopOld === $existingLoop) {
					$this->loop[$key] = $loopNew;
					$existingLoop->setParent();
					$this->setSelfAsSubNodeParent($loopNew, 'loop');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr[] $loop
	 * @return \PHPParser_Node_Stmt_For
	 */
	public function setLoop(array $loop = NULL) {
		$this->loop = $loop;
		$this->setSelfAsSubNodeParent($loop, 'loop');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getLoopExprAtIndex($index = NULL) {
		if (isset($this->loop[$index])) {
			return $this->loop[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr[]
	 */
	public function getLoop() {
		return $this->loop;
	}

	/**
	 * @stmt PHPParser_Node $stmt
	 */
	public function appendStmt(PHPParser_Node $stmt) {
		if (!is_array($this->stmts)) {
			$this->stmts = array();
		}
		$this->stmts[] = $stmt;
		$this->setSelfAsSubNodeParent($stmt, 'stmts');
	}

	/**
	 * @stmt PHPParser_Node $stmt
	 */
	public function removeStmt(PHPParser_Node $stmt) {
		if (!is_array($this->stmts)) {
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
		if (!is_array($this->stmts)) {
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
	 * @return \PHPParser_Node_Stmt_For
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