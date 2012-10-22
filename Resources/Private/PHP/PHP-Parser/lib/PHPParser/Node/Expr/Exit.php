<?php

class PHPParser_Node_Expr_Exit extends PHPParser_Node_Expr_AbstractSingleExpr {

	/**
	 * Constructs a abstract expression containing node.
	 *
	 * @param null|PHPParser_Node_Expr $expr Expression
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $expr = NULL, $line = -1, $ignorables = array()) {
		if (NULL !== $expr) {
			$this->setExpr($expr);
		}
		PHPParser_NodeAbstract::__construct($line, $ignorables);
	}

}