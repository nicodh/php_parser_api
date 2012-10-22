<?php

class PHPParser_Node_Expr_FuncCall extends PHPParser_Node_Expr {

	/**
	 * Function name
	 *
	 * @var PHPParser_Node_Name|PHPParser_Node_Expr
	 */
	protected $name;

	/**
	 * Arguments
	 *
	 * @var PHPParser_Node_Arg[]
	 */
	protected $args;

	/**
	 * Constructs a function call node.
	 *
	 * @param PHPParser_Node_Name|PHPParser_Node_Expr $name Function name
	 * @param PHPParser_Node_Arg[] $args Arguments
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, array $args = array(), $line = -1, $ignorables = array()) {
		$this->setName($name);
		$this->setArgs($args);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @arg PHPParser_Node_Arg $arg
	 */
	public function appendArg(PHPParser_Node_Arg $arg) {
		if (NULL != $this->args) {
			$this->args = array();
		}
		$this->args[] = $arg;
		$this->setSelfAsSubNodeParent($arg, 'args');
	}

	/**
	 * @arg PHPParser_Node_Arg $arg
	 */
	public function removeArg(PHPParser_Node_Arg $arg) {
		if (NULL !== $this->args) {
			foreach ($this->args as $key => $existingArg) {
				if ($arg === $existingArg) {
					unset($this->args[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @arg PHPParser_Node_Arg $argNew
	 * @arg PHPParser_Node_Arg $argOld
	 */
	public function replaceArg(PHPParser_Node_Arg $argNew, PHPParser_Node_Arg $argOld) {
		if (NULL !== $this->args) {
			foreach ($this->args as $key => $existingArg) {
				if ($argOld === $existingArg) {
					$this->args[$key] = $argNew;
					$existingArg->setParent();
					$this->setSelfAsSubNodeParent($argNew, 'args');
					break;
				}
			}
		}
	}

	/**
	 * @param \PHPParser_Node_Arg[] $args
	 * @return \PHPParser_Node_Expr_FuncCall
	 */
	public function setArgs(array $args = NULL) {
		$this->args = $args;
		$this->setSelfAsSubNodeParent($args, 'args');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Arg
	 */
	public function getArgAtIndex($index = NULL) {
		if (isset($this->args[$index])) {
			return $this->args[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Arg[]
	 */
	public function getArgs() {
		return $this->args;
	}

	/**
	 * @param \PHPParser_Node_Expr|\PHPParser_Node_Name $name
	 * @return \PHPParser_Node_Expr_FuncCall
	 */
	public function setName($name = NULL) {
		if (NULL !== $name && !$name instanceof PHPParser_Node_Expr && !$name instanceof PHPParser_Node_Name) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' expects $type to be either PHPParser_Node_Expr or PHPParser_Node_Name. ' . gettype($name) . ' given.', 1337628890);
		}
		$this->name = $name;
		$this->setSelfAsSubNodeParent($name, 'name');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr|\PHPParser_Node_Name
	 */
	public function getName() {
		return $this->name;
	}
}