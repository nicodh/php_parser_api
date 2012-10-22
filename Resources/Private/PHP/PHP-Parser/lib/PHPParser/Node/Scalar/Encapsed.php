<?php

/**
 * @property array $parts Encaps list
 */
class PHPParser_Node_Scalar_Encapsed extends PHPParser_Node_Scalar {

	/**
	 * Contains parts
	 *
	 * @var array
	 */
	protected $parts;

	/**
	 * Constructs an encapsed string node.
	 *
	 * @param array $parts Encaps list
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $parts = array(), $line = -1, $ignorables = array()) {
		$this->setParts($parts);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param array $parts
	 */
	public function setParts(array $parts = NULL) {
		$this->parts = $parts;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParts() {
		return $this->parts;
	}
}