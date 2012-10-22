<?php

/**
 * @property string                $name    Name
 * @property PHPParser_Node_Name[] $extends Extended interfaces
 * @property PHPParser_Node[]      $stmts   Statements
 */
class PHPParser_Node_Stmt_Interface extends PHPParser_Node_Stmt {

	/**
	 * Contains extends
	 *
	 * @var PHPParser_Node_Name[]
	 */
	protected $extends;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * @var array
	 */
	protected static $specialNames = array(
		'self' => TRUE,
		'parent' => TRUE,
		'static' => TRUE,
	);

	/**
	 * Constructs a class node.
	 *
	 * @param string $name Name
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                'extends' => array(): Name of extended interfaces
	 *                                'stmts'   => array(): Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, array $subNodes = array(), $line = -1, $ignorables = array()) {
		parent::__construct($line, $ignorables);
		$this->setName($name);
		if (isset($subNodes['extends']) && NULL !== $subNodes['extends']) {
			$this->setExtends($subNodes['extends']);
		}
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
	}

	/**
	 * @param PHPParser_Node_Name $extend
	 */
	public function appendExtend(PHPParser_Node_Name $extend) {
		if (NULL != $this->extends) {
			$this->extends = array();
		}
		$this->extends[] = $extend;
		$this->setSelfAsSubNodeParent($extend, 'extends');
	}

	/**
	 * @param PHPParser_Node_Name $extend
	 */
	public function removeExtend(PHPParser_Node_Name $extend) {
		if (NULL !== $this->extends) {
			foreach ($this->extends as $key => $existingExtend) {
				if ($extend === $existingExtend) {
					unset($this->extends[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Name $extendNew
	 * @param PHPParser_Node_Name $extendOld
	 */
	public function replaceExtend(PHPParser_Node_Name $extendNew, PHPParser_Node_Name $extendOld) {
		if (NULL !== $this->extends) {
			foreach ($this->extends as $key => $existingExtend) {
				if ($extendOld === $existingExtend) {
					$this->extends[$key] = $extendNew;
					$existingExtend->setParent();
					$this->setSelfAsSubNodeParent($extendNew, 'extends');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Name[] $extends
	 * @return \PHPParser_Node_Stmt_Interface
	 */
	public function setExtends(array $extends = NULL) {
		if (NULL !== $extends) {
			foreach ($extends as $interface) {
				$interfaceString = (string)$interface;
				if (isset(self::$specialNames[strtolower($interfaceString)])) {
					throw new PHPParser_Error('Cannot use "' . $interfaceString . '" as interface name as it is reserved', $interface->getLine());
				}
			}
		}
		$this->extends = $extends;
		$this->setSelfAsSubNodeParent($extends, 'extends');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Name
	 */
	public function getExtendAtIndex($index = NULL) {
		if (isset($this->extends[$index])) {
			return $this->extends[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Name[]
	 */
	public function getExtends() {
		return $this->extends;
	}

	/**
	 * @param string $name
	 * @return \PHPParser_Node_Stmt_Interface
	 */
	public function setName($name) {
		$name = (string)$name;
		if (isset(self::$specialNames[strtolower($name)])) {
			throw new PHPParser_Error('Cannot use "' . $name . '" as interface name as it is reserved', $this->getLine());
		}
		$this->name = $name;
		$this->setSelfAsSubNodeParent($name, 'name');
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
	 * @return \PHPParser_Node_Stmt_Interface
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