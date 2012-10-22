<?php

class PHPParser_Node_Expr_StaticCall extends PHPParser_Node_Expr {

	/**
	 * Contains class
	 *
	 * @var PHPParser_Node_Name|PHPParser_Node_Expr
	 */
	protected $class;

	/**
	 * Contains name
	 *
	 * @var string|PHPParser_Node_Expr
	 */
	protected $name;

	/**
	 * Contains args
	 *
	 * @var PHPParser_Node_Arg[]
	 */
	protected $args;

	/**
	 * Constructs a static method call node.
	 *
	 * @param PHPParser_Node_Name|PHPParser_Node_Expr $class Class name
	 * @param string|PHPParser_Node_Expr $name Method name
	 * @param PHPParser_Node_Arg[] $args Arguments
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($class, $name, array $args = array(), $line = -1, $ignorables = array()) {
		$this->setClass($class);
		$this->setName($name);
		$this->setArgs($args);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Name|PHPParser_Node_Expr $class
	 * @return \PHPParser_Node_Expr_StaticCall
	 */
	public function setClass($class = NULL) {
		if (!NULL !== $class && !$class instanceof PHPParser_Node_Name && !$class instanceof PHPParser_Node_Expr) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' expects type to be either PHPParser_Node_Name or PHPParser_Node_Expr. ' . gettype($class) . ' given.', 1337626734);
		}
		$this->class = $class;
		$this->setSelfAsSubNodeParent($class, 'class');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Name|PHPParser_Node_Expr
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * @param string|PHPParser_Node_Expr $name
	 * @return \PHPParser_Node_Expr_StaticCall
	 */
	public function setName($name = NULL) {
		if (NULL !== $name && !is_string($name) && !$name instanceof PHPParser_Node_Expr) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' expects type to be either string or PHPParser_Node_Expr. ' . gettype($name) . ' given.', 1337626739);
		}
		$this->name = $name;
		$this->setSelfAsSubNodeParent($name, 'name');
		return $this;
	}

	/**
	 * @return string|PHPParser_Node_Expr
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param PHPParser_Node_Arg $arg
	 */
	public function appendArg(PHPParser_Node_Arg $arg) {
		if (NULL != $this->args) {
			$this->args = array();
		}
		$this->args[] = $arg;
		$this->setSelfAsSubNodeParent($arg, 'args');
	}

	/**
	 * @param PHPParser_Node_Arg $arg
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
	 * @param PHPParser_Node_Arg $argNew
	 * @param PHPParser_Node_Arg $argOld
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
	 * @param PHPParser_Node_Arg[] $args
	 * @return \PHPParser_Node_Expr_StaticCall
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
}