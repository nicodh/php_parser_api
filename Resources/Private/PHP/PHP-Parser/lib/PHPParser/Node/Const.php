<?php

/**
 * @property string              $name  Name
 * @property PHPParser_Node_Expr $value Value
 */
class PHPParser_Node_Const extends PHPParser_NodeAbstract {

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Contains value
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $value;

	/**
	 * Constructs a const node for use in class const and const statements.
	 *
	 * @param string $name Name
	 * @param PHPParser_Node_Expr $value Value
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct($name, PHPParser_Node_Expr $value, $line = -1, $ignorables = array()) {
		$this->name = $name;
		$this->value = $value;
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string $name
	 * @return \PHPParser_Node_Const
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param PHPParser_Node_Expr $value
	 * @return \PHPParser_Node_Const
	 */
	public function setValue(PHPParser_Node_Expr $value = NULL) {
		$this->value = $value;
		$this->setSelfAsSubNodeParent($value, 'value');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getValue() {
		return $this->value;
	}
}