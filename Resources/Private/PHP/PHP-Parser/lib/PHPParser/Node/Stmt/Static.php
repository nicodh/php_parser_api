<?php

/**
 * @property PHPParser_Node_Stmt_StaticVar[] $vars Variable definitions
 */
class PHPParser_Node_Stmt_Static extends PHPParser_Node_Stmt {

	/**
	 * Contains vars
	 *
	 * @var PHPParser_Node_Stmt_StaticVar[]
	 */
	protected $vars;

	/**
	 * Constructs a static variables list node.
	 *
	 * @param PHPParser_Node_Stmt_StaticVar[] $vars Variable definitions
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $vars, $line = -1, $ignorables = array()) {
		$this->setVars($vars);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Stmt_StaticVar $var
	 */
	public function appendVar(PHPParser_Node_Stmt_StaticVar $var) {
		if (NULL != $this->vars) {
			$this->vars = array();
		}
		$this->vars[] = $var;
		$this->setSelfAsSubNodeParent($var, 'vars');
	}

	/**
	 * @param PHPParser_Node_Stmt_StaticVar $var
	 */
	public function removeVar(PHPParser_Node_Stmt_StaticVar $var) {
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
	 * @param PHPParser_Node_Stmt_StaticVar $varNew
	 * @param PHPParser_Node_Stmt_StaticVar $varOld
	 */
	public function replaceVar(PHPParser_Node_Stmt_StaticVar $varNew, PHPParser_Node_Stmt_StaticVar $varOld) {
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
	 * @param PHPParser_Node_Stmt_StaticVar[] $vars
	 * @return \PHPParser_Node_Stmt_Static
	 */
	public function setVars(array $vars) {
		$this->vars = $vars;
		$this->setSelfAsSubNodeParent($vars, 'vars');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_StaticVar
	 */
	public function getVarAtIndex($index = NULL) {
		if (isset($this->vars[$index])) {
			return $this->vars[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_StaticVar[]
	 */
	public function getVars() {
		return $this->vars;
	}
}