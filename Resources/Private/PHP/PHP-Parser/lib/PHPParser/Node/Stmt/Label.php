<?php

/**
 * @property string $name Name
 */
class PHPParser_Node_Stmt_Label extends PHPParser_Node_Stmt {

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Constructs a label node.
	 *
	 * @param string $name Name
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, $line = -1, $ignorables = array()) {
		$this->setName($name);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string $name
	 * @return \PHPParser_Node_Stmt_Label
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