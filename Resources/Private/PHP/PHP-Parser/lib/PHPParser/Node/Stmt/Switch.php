<?php

/**
 * @property PHPParser_Node_Expr        $cond  Condition
 * @property PHPParser_Node_Stmt_Case[] $cases Case list
 */
class PHPParser_Node_Stmt_Switch extends PHPParser_Node_Stmt {

	/**
	 * Contains cond
	 *
	 * @var PHPParser_Node_Expr
	 */
	protected $cond;

	/**
	 * Contains cases
	 *
	 * @var PHPParser_Node_Stmt_Case[]
	 */
	protected $cases;

	/**
	 * Constructs a case node.
	 *
	 * @param PHPParser_Node_Expr $cond Condition
	 * @param PHPParser_Node_Stmt_Case[] $cases Case list
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(PHPParser_Node_Expr $cond, array $cases, $line = -1, $ignorables = array()) {
		$this->setCond($cond);
		$this->setCases($cases);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Stmt_Case $case
	 */
	public function appendCase(PHPParser_Node_Stmt_Case $case) {
		if (NULL != $this->cases) {
			$this->cases = array();
		}
		$this->cases[] = $case;
		$this->setSelfAsSubNodeParent($case, 'cases');
	}

	/**
	 * @param PHPParser_Node_Stmt_Case $case
	 */
	public function removeCase(PHPParser_Node_Stmt_Case $case) {
		if (NULL !== $this->cases) {
			foreach ($this->cases as $key => $existingCase) {
				if ($case === $existingCase) {
					unset($this->cases[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_Case $caseNew
	 * @param PHPParser_Node_Stmt_Case $caseOld
	 */
	public function replaceCase(PHPParser_Node_Stmt_Case $caseNew, PHPParser_Node_Stmt_Case $caseOld) {
		if (NULL !== $this->cases) {
			foreach ($this->cases as $key => $existingCase) {
				if ($caseOld === $existingCase) {
					$this->cases[$key] = $caseNew;
					$existingCase->setParent();
					$this->setSelfAsSubNodeParent($caseNew, 'cases');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_Case[] $cases
	 * @return \PHPParser_Node_Stmt_Switch
	 */
	public function setCases(array $cases) {
		$this->cases = $cases;
		$this->setSelfAsSubNodeParent($cases, 'cases');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_Case
	 */
	public function getCaseAtIndex($index = NULL) {
		if (isset($this->cases[$index])) {
			return $this->cases[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_Case[]
	 */
	public function getCases() {
		return $this->cases;
	}

	/**
	 * @param PHPParser_Node_Expr $cond
	 * @return \PHPParser_Node_Stmt_Switch
	 */
	public function setCond(PHPParser_Node_Expr $cond = NULL) {
		$this->cond = $cond;
		$this->setSelfAsSubNodeParent($cond, 'cond');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Expr
	 */
	public function getCond() {
		return $this->cond;
	}
}