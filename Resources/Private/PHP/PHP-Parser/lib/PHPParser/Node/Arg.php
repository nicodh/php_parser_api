<?php

/**
 * @property PHPParser_Node_Expr $value Value to pass
 * @property bool                $byRef Whether to pass by ref
 */
class PHPParser_Node_Arg extends PHPParser_NodeAbstract {

	/**
	 * Contains value
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $value;

	/**
	 * Contains byRef
	 *
	 * @var bool
	 */
	protected $byRef;

	/**
	 * Constructs a function call argument node.
	 *
	 * @param PHPParser_Node_Expr $value Value to pass
	 * @param bool $byRef Whether to pass by ref
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $value, $byRef = FALSE, $line = -1, $ignorables = array()) {
		$this->setValue($value);
		$this->setByRef($byRef);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param $byRef
	 * @return \PHPParser_Node_Arg
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
	 * @param PHPParser_Node_Expr $value
	 * @return \PHPParser_Node_Arg
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