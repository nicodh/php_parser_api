<?php

/**
 * @property null|PHPParser_Node_Name $trait       Trait name
 * @property string                   $method      Method name
 * @property null|int                 $newModifier New modifier
 * @property null|string              $newName     New name
 */
class PHPParser_Node_Stmt_TraitUseAdaptation_Alias extends PHPParser_Node_Stmt_TraitUseAdaptation {

	/**
	 * Contains trait
	 *
	 * @var PHPParser_Node_Name
	 */
	protected $trait;

	/**
	 * Contains method
	 *
	 * @var string
	 */
	protected $method;

	/**
	 * Contains newModifier
	 *
	 * @var int
	 */
	protected $newModifier;

	/**
	 * Contains newName
	 *
	 * @var string
	 */
	protected $newName;

	/**
	 * Constructs a trait use precedence adaptation node.
	 *
	 * @param null|PHPParser_Node_Name $trait Trait name
	 * @param string $method Method name
	 * @param null|int $newModifier New modifier
	 * @param null|string $newName New name
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($trait, $method, $newModifier, $newName, $line = -1, $ignorables = array()) {
		if (NULL !== $trait) {
			$this->setTrait($trait);
		}
		$this->setMethod($method);
		$this->setNewModifier($newModifier);
		$this->setNewName($newName);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param string $method
	 * @return \PHPParser_Node_Stmt_TraitUseAdaptation_Alias
	 */
	public function setMethod($method) {
		$this->method = (string)$method;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * @param int $newModifier
	 * @return \PHPParser_Node_Stmt_TraitUseAdaptation_Alias
	 */
	public function setNewModifier($newModifier) {
		$this->newModifier = (int)$newModifier;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getNewModifier() {
		return $this->newModifier;
	}

	/**
	 * @param string $newName
	 * @return \PHPParser_Node_Stmt_TraitUseAdaptation_Alias
	 */
	public function setNewName($newName) {
		$this->newName = (string)$newName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getNewName() {
		return $this->newName;
	}

	/**
	 * @param PHPParser_Node_Name $trait
	 * @return \PHPParser_Node_Stmt_TraitUseAdaptation_Alias
	 */
	public function setTrait(PHPParser_Node_Name $trait = NULL) {
		$this->trait = $trait;
		$this->setSelfAsSubNodeParent($trait, 'trait');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Name
	 */
	public function getTrait() {
		return $this->trait;
	}
}