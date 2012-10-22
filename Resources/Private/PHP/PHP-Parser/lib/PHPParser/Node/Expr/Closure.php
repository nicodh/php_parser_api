<?php

class PHPParser_Node_Expr_Closure extends PHPParser_Node_Expr {

	/**
	 * Whether the closure is static
	 *
	 * @var bool
	 */
	protected $static = FALSE;

	/**
	 * Whether to return by reference
	 *
	 * @var bool
	 */
	protected $byRef = FALSE;

	/**
	 * Parameters
	 *
	 * @var PHPParser_Node_Param[]
	 */
	protected $params;

	/**
	 * use()s
	 *
	 * @var PHPParser_Node_Expr_ClosureUse[]
	 */
	protected $uses;

	/**
	 * Statements
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Constructs a lambda function node.
	 *
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                'stmts'  => array(): Statements
	 *                                'params' => array(): Parameters
	 *                                'uses'   => array(): use()s
	 *                                'byRef'  => false  : Whether to return by reference
	 *                                'static' => false  : Whether the closure is static
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(array $subNodes = array(), $line = -1, $ignorables = array()) {
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
		if (isset($subNodes['params']) && NULL !== $subNodes['params']) {
			$this->setParams($subNodes['params']);
		}
		if (isset($subNodes['uses']) && NULL !== $subNodes['uses']) {
			$this->setUses($subNodes['uses']);
		}
		if (isset($subNodes['byRef']) && NULL !== $subNodes['byRef']) {
			$this->setByRef($subNodes['byRef']);
		}
		if (isset($subNodes['static']) && NULL !== $subNodes['static']) {
			$this->setStatic($subNodes['static']);
		}
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param boolean $byRef
	 * @return \PHPParser_Node_Expr_Closure
	 */
	public function setByRef($byRef) {
		$this->byRef = (bool)$byRef;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getByRef() {
		return $this->byRef;
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
	 * @return \PHPParser_Node_Expr_Closure
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
	 * @param boolean $static
	 * @return \PHPParser_Node_Expr_Closure
	 */
	public function setStatic($static) {
		$this->static = (bool)$static;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getStatic() {
		return $this->static;
	}

	/**
	 * @param PHPParser_Node[] $stmts
	 * @return \PHPParser_Node_Expr_Closure
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
	 * @param PHPParser_Node_Expr_ClosureUse $use
	 */
	public function appendUse(PHPParser_Node_Expr_ClosureUse $use) {
		if (NULL != $this->uses) {
			$this->uses = array();
		}
		$this->uses[] = $use;
		$this->setSelfAsSubNodeParent($use, 'uses');
	}

	/**
	 * @param PHPParser_Node_Expr_ClosureUse $use
	 */
	public function removeUse(PHPParser_Node_Expr_ClosureUse $use) {
		if (NULL !== $this->uses) {
			foreach ($this->uses as $key => $existingUse) {
				if ($use === $existingUse) {
					unset($this->uses[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr_ClosureUse $useNew
	 * @param PHPParser_Node_Expr_ClosureUse $useOld
	 */
	public function replaceUse(PHPParser_Node_Expr_ClosureUse $useNew, PHPParser_Node_Expr_ClosureUse $useOld) {
		if (NULL !== $this->uses) {
			foreach ($this->uses as $key => $existingUse) {
				if ($useOld === $existingUse) {
					$this->uses[$key] = $useNew;
					$existingUse->setParent();
					$this->setSelfAsSubNodeParent($useNew, 'uses');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr_ClosureUse[] $uses
	 * @return \PHPParser_Node_Expr_Closure
	 */
	public function setUses(array $uses = NULL) {
		$this->uses = $uses;
		$this->setSelfAsSubNodeParent($uses, 'uses');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr_ClosureUse
	 */
	public function getUseAtIndex($index = NULL) {
		if (isset($this->uses[$index])) {
			return $this->uses[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr_ClosureUse[]
	 */
	public function getUses() {
		return $this->uses;
	}
}