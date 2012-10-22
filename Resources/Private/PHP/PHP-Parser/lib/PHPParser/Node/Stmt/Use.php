<?php

/**
 * @property PHPParser_Node_Stmt_UseUse[] $uses Aliases
 */
class PHPParser_Node_Stmt_Use extends PHPParser_Node_Stmt {

	/**
	 * Contains uses
	 *
	 * @var PHPParser_Node_Stmt_UseUse[]
	 */
	protected $uses;

	/**
	 * Constructs an alias (use) list node.
	 *
	 * @param PHPParser_Node_Stmt_UseUse[] $uses Aliases
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $uses, $line = -1, $ignorables = array()) {
		$this->setUses($uses);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Stmt_UseUse $use
	 */
	public function appendUse(PHPParser_Node_Stmt_UseUse $use) {
		if (NULL === $this->uses) {
			$this->uses = array();
		}
		$this->uses[] = $use;
		$this->setSelfAsSubNodeParent($use, 'uses');
	}

	/**
	 * @param PHPParser_Node_Stmt_UseUse $use
	 */
	public function removeUse(PHPParser_Node_Stmt_UseUse $use) {
		if (NULL !== $this->uses) {
			foreach ($this->uses as $key => $existingUse) {
				if ($use === $existingUse) {
					unset($this->uses[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_UseUse $useNew
	 * @param PHPParser_Node_Stmt_UseUse $useOld
	 */
	public function replaceUse(PHPParser_Node_Stmt_UseUse $useNew, PHPParser_Node_Stmt_UseUse $useOld) {
		if (NULL !== $this->uses) {
			foreach ($this->uses as $key => $existingUse) {
				if ($useOld === $existingUse) {
					$this->uses[$key] = $useNew;
					$existingUse->setParent();
					$this->setSelfAsSubNodeParent($useNew, 'uses');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_UseUse[] $uses
	 * @return \PHPParser_Node_Stmt_Use
	 */
	public function setUses(array $uses) {
		$this->uses = $uses;
		$this->setSelfAsSubNodeParent($uses, 'uses');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_UseUse
	 */
	public function getUseAtIndex($index = NULL) {
		if (isset($this->uses[$index])) {
			return $this->uses[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_UseUse[]
	 */
	public function getUses() {
		return $this->uses;
	}

	/**
	 * @return array
	 */
	public function getAliases() {
		$aliases = array();
		foreach ($this->uses as $use) {
			$aliases[] = $use->getAlias() ? : $use->getName()->getLast();
		}
		return $aliases;
	}
}