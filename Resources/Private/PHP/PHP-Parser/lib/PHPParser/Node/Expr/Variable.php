<?php

class PHPParser_Node_Expr_Variable extends PHPParser_Node_Expr {

	/**
	 * Contains name
	 *
	 * @var string|PHPParser_Node_Expr
	 */
	protected $name;

	/**
	 * Constructs a variable node.
	 *
	 * @param string|PHPParser_Node_Expr $name Name
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, $line = -1, $ignorables = array()) {
		$this->setName($name);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string|PHPParser_Node_Expr $name
	 * @return \PHPParser_Node_Expr_Variable
	 */
	public function setName($name = NULL) {
		if (NULL !== $name && !is_string($name) && !$name instanceof PHPParser_Node_Expr) {
			throw new InvalidArgumentException(__CLASS__ . '::' . __METHOD__ . ' expects $type to be either string or PHPParser_Node_Expr. ' . gettype($name) . ' given.', 1337626174);
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
}