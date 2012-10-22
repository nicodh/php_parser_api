<?php

class PHPParser_Node_Stmt_PropertyProperty extends PHPParser_Node_Stmt {

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Contains default
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $default;

	/**
	 * Constructs a class property node.
	 *
	 * @param string $name Name
	 * @param null|PHPParser_Node_Expr $default Default value
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, PHPParser_Node_Expr $default = NULL, $line = -1, $ignorables = array()) {
		$this->setName($name);
		if (NULL !== $default) {
			$this->setDefault($default);
		}
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Expr $default
	 * @return \PHPParser_Node_Stmt_PropertyProperty
	 */
	public function setDefault(PHPParser_Node_Expr $default = NULL) {
		$this->default = $default;
		$this->setSelfAsSubNodeParent($default, 'default');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * @param string $name
	 * @return \PHPParser_Node_Stmt_PropertyProperty
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
}