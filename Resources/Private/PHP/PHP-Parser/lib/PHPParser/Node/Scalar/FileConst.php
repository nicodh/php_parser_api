<?php

class PHPParser_Node_Scalar_FileConst extends PHPParser_Node_Scalar {

	/**
	 * Constructs a __FILE__ const node
	 *
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($line = -1, $ignorables = array()) {
		parent::__construct($line, $ignorables);
	}
}