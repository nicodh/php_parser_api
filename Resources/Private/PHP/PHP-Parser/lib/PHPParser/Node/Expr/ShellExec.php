<?php

class PHPParser_Node_Expr_ShellExec extends PHPParser_Node_Expr {

	/**
	 * Encapsed string array
	 *
	 * @var array
	 */
	protected $parts;

	/**
	 * Constructs a shell exec (backtick) node.
	 *
	 * @param array $parts Encapsed string array
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $parts, $line = -1, $ignorables = array()) {
		$this->setParts($parts);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param array $parts
	 * @return \PHPParser_Node_Expr_ShellExec
	 */
	public function setParts(array $parts) {
		$this->parts = $parts;
		$this->setSelfAsSubNodeParent($parts, 'parts');
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParts() {
		return $this->parts;
	}
}