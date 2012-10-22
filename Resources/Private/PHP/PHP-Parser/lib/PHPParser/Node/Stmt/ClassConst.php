<?php

/**
 * @property PHPParser_Node_Const[] $consts Constant declarations
 */
class PHPParser_Node_Stmt_ClassConst extends PHPParser_Node_Stmt {

	/**
	 * Contains consts
	 *
	 * @var PHPParser_Node_Const[]
	 */
	protected $consts;

	/**
	 * Constructs a class const list node.
	 *
	 * @param PHPParser_Node_Const[] $consts Constant declarations
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $consts, $line = -1, $ignorables = array()) {
		$this->setConsts($consts);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Const $const
	 */
	public function appendConst(PHPParser_Node_Const $const) {
		if (NULL != $this->consts) {
			$this->consts = array();
		}
		$this->consts[] = $const;
		$this->setSelfAsSubNodeParent($const, 'consts');
	}

	/**
	 * @param PHPParser_Node_Const $const
	 */
	public function removeConst(PHPParser_Node_Const $const) {
		if (NULL !== $this->consts) {
			foreach ($this->consts as $key => $existingConst) {
				if ($const === $existingConst) {
					unset($this->consts[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Const $constNew
	 * @param PHPParser_Node_Const $constOld
	 */
	public function replaceConst(PHPParser_Node_Const $constNew, PHPParser_Node_Const $constOld) {
		if (NULL !== $this->consts) {
			foreach ($this->consts as $key => $existingConst) {
				if ($constOld === $existingConst) {
					$this->consts[$key] = $constNew;
					$existingConst->setParent();
					$this->setSelfAsSubNodeParent($constNew, 'consts');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Const[] $consts
	 * @return \PHPParser_Node_Stmt_ClassConst
	 */
	public function setConsts(array $consts = NULL) {
		$this->consts = $consts;
		$this->setSelfAsSubNodeParent($consts, 'consts');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Const
	 */
	public function getConstAtIndex($index = NULL) {
		if (isset($this->consts[$index])) {
			return $this->consts[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Const[]
	 */
	public function getConsts() {
		return $this->consts;
	}
}