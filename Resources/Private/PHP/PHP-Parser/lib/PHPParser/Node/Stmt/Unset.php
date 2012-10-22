<?php

/**
 * @property PHPParser_Node_Expr[] $vars Variables to unset
 */
class PHPParser_Node_Stmt_Unset extends PHPParser_Node_Stmt {

	/**
	 * Contains vars
	 *
	 * @var PHPParser_Node_Expr[]
	 */
	protected $vars;

	/**
	 * Constructs an unset node.
	 *
	 * @param PHPParser_Node_Expr[] $vars Variables to unset
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $vars, $line = -1, $ignorables = array()) {
		$this->setVars($vars);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Expr $var
	 */
	public function appendVar(PHPParser_Node_Expr $var) {
		if (NULL != $this->vars) {
			$this->vars = array();
		}
		$this->vars[] = $var;
		$this->setSelfAsSubNodeParent($var, 'vars');
	}

	/**
	 * @param PHPParser_Node_Expr $var
	 */
	public function removeVar(PHPParser_Node_Expr $var) {
		if (NULL !== $this->vars) {
			foreach ($this->vars as $key => $existingVar) {
				if ($var === $existingVar) {
					unset($this->vars[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr $varNew
	 * @param PHPParser_Node_Expr $varOld
	 */
	public function replaceVar(PHPParser_Node_Expr $varNew, PHPParser_Node_Expr $varOld) {
		if (NULL !== $this->vars) {
			foreach ($this->vars as $key => $existingVar) {
				if ($varOld === $existingVar) {
					$this->vars[$key] = $varNew;
					$existingVar->setParent();
					$this->setSelfAsSubNodeParent($varNew, 'vars');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr[] $vars
	 * @return \PHPParser_Node_Stmt_Unset
	 */
	public function setVars(array $vars) {
		$this->vars = $vars;
		$this->setSelfAsSubNodeParent($vars, 'vars');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getVarAtIndex($index = NULL) {
		if (isset($this->vars[$index])) {
			return $this->vars[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr[]
	 */
	public function getVars() {
		return $this->vars;
	}
}