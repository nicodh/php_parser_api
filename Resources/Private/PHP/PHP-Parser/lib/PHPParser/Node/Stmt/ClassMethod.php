<?php

/**
 * @property int                    $type   Type
 * @property bool                   $byRef  Whether to return by reference
 * @property string                 $name   Name
 * @property PHPParser_Node_Param[] $params Parameters
 * @property PHPParser_Node[]       $stmts  Statements
 */
class PHPParser_Node_Stmt_ClassMethod extends PHPParser_Node_Stmt {

	/**
	 * Contains type
	 *
	 * @var int
	 */
	protected $type = PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC;

	/**
	 * Contains byRef
	 *
	 * @var bool
	 */
	protected $byRef;

	/**
	 * Contains params
	 *
	 * @var PHPParser_Node_Param[]
	 */
	protected $params;

	/**
	 * Contains stmts
	 *
	 * @var null|PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Constructs a class method node.
	 *
	 * @param string $name Name
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                'type'   => MODIFIER_PUBLIC: Type
	 *                                'byRef'  => false          : Whether to return by reference
	 *                                'params' => array()        : Parameters
	 *                                'stmts'  => array()        : Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, array $subNodes = array(), $line = -1, $ignorables = array()) {
		$this->setName($name);
		if (isset($subNodes['type']) && NULL !== $subNodes['type']) {
			$this->setType($subNodes['type']);
		}
		if (isset($subNodes['byRef']) && NULL !== $subNodes['byRef']) {
			$this->setByRef($subNodes['byRef']);
		}
		if (isset($subNodes['params']) && NULL !== $subNodes['params']) {
			$this->setParams($subNodes['params']);
		}
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param bool $byRef
	 * @return \PHPParser_Node_Stmt_ClassMethod
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
	 * @param string $name
	 * @return \PHPParser_Node_Stmt_ClassMethod
	 */
	public function setName($name) {
		$this->checkTypeAndNameConstraint($this->type, $name);
		$this->name = (string)$name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param PHPParser_Node_Param $param
	 */
	public function appendParam(PHPParser_Node_Param $param) {
		if (NULL != $this->params) {
			$this->params = array();
		}
		$this->params[] = $param;
		$this->setSelfAsSubNodeParent($param, 'params');
	}

	/**
	 * @param PHPParser_Node_Param $param
	 */
	public function removeParam(PHPParser_Node_Param $param) {
		if (NULL !== $this->params) {
			foreach ($this->params as $key => $existingParam) {
				if ($param === $existingParam) {
					unset($this->params[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Param $paramNew
	 * @param PHPParser_Node_Param $paramOld
	 */
	public function replaceParam(PHPParser_Node_Param $paramNew, PHPParser_Node_Param $paramOld) {
		if (NULL !== $this->params) {
			foreach ($this->params as $key => $existingParam) {
				if ($paramOld === $existingParam) {
					$this->params[$key] = $paramNew;
					$existingParam->setParent();
					$this->setSelfAsSubNodeParent($paramNew, 'params');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Param[] $params
	 * @return \PHPParser_Node_Stmt_ClassMethod
	 */
	public function setParams(array $params = NULL) {
		$this->params = $params;
		$this->setSelfAsSubNodeParent($params, 'params');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Param
	 */
	public function getParamAtIndex($index = NULL) {
		if (isset($this->params[$index])) {
			return $this->params[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Param[]
	 */
	public function getParams() {
		return $this->params;
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
	 * @return \PHPParser_Node_Stmt_ClassMethod
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
	 * @param int $type
	 * @return \PHPParser_Node_Stmt_ClassMethod
	 */
	public function setType($type) {
		$this->checkTypeAndNameConstraint($type, $this->name);
		$this->type = $type;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param int $type
	 * @param string $name
	 * @throws PHPParser_Error
	 */
	protected function checkTypeAndNameConstraint($type, $name) {
		$type = (int)$type;
		$name = (string)$name;
		if (($type & PHPParser_Node_Stmt_Class::MODIFIER_STATIC) && ('__construct' == $name || '__destruct' == $name || '__clone' == $name)) {
			throw new PHPParser_Error(sprintf('"%s" method cannot be static', $this->name));
		}
	}
}