<?php

/**
 * @property string $name Name of label to jump to
 */
class PHPParser_Node_Stmt_Goto extends PHPParser_Node_Stmt {

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Constructs a goto node.
	 *
	 * @param string $name Name of label to jump to
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, $line = -1, $ignorables = array()) {
		$this->setName($name);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string $name
	 * @return \PHPParser_Node_Stmt_Goto
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