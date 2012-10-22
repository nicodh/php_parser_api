<?php

/**
 *
 */
class PHPParser_Node_Expr_ConstFetch extends PHPParser_Node_Expr {

	/**
	 * Constant name
	 *
	 * @var PHPParser_Node_Name
	 */
	protected $name;

	/**
	 * Constructs a const fetch node.
	 *
	 * @param PHPParser_Node_Name $name Constant name
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Name $name, $line = -1, $ignorables = array()) {
		$this->setName($name);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param \PHPParser_Node_Name $name
	 * @return \PHPParser_Node_Expr_ConstFetch
	 */
	public function setName(PHPParser_Node_Name $name = NULL) {
		$this->name = $name;
		$this->setSelfAsSubNodeParent($name, 'name');
		return $this;
	}

	/**
	 * @return \PHPParser_Node_Name
	 */
	public function getName() {
		return $this->name;
	}
}