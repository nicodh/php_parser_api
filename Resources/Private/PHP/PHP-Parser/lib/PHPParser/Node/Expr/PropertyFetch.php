<?php

class PHPParser_Node_Expr_PropertyFetch extends PHPParser_Node_Expr {

	/**
	 * Variable holding object
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $var;

	/**
	 * Property Name
	 *
	 * @var string|PHPParser_Node_Expr
	 */
	protected $name;

	/**
	 * Constructs a function call node.
	 *
	 * @param PHPParser_Node_Expr $var Variable holding object
	 * @param string|PHPParser_Node_Expr $name Property name
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $var, $name, $line = -1, $ignorables = array()) {
		$this->setVar($var);
		$this->setName($name);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Expr|string $name
	 * @return \PHPParser_Node_Expr_PropertyFetch
	 */
	public function setName($name = NULL) {
		if (NULL !== $name && !is_string($name) && !$name instanceof PHPParser_Node_Expr) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' expects $type to be either string or PHPParser_Node_Expr. ' . gettype($name) . ' given.', 1337629848);
		}
		$this->name = $name;
		$this->setSelfAsSubNodeParent($name, 'name');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr|string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param \PHPParser_Node_Expr $var
	 * @return \PHPParser_Node_Expr_PropertyFetch
	 */
	public function setVar(PHPParser_Node_Expr $var = NULL) {
		$this->var = $var;
		$this->setSelfAsSubNodeParent($var, 'var');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Expr
	 */
	public function getVar() {
		return $this->var;
	}
}