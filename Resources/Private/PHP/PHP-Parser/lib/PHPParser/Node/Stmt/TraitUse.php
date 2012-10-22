<?php

/**
 * @property PHPParser_Node_Name[]               $traits      Traits
 * @property PHPParser_Node_Stmt_TraitUseAdaptation[] $adaptations Adaptations
 */
class PHPParser_Node_Stmt_TraitUse extends PHPParser_Node_Stmt {

	/**
	 * Contains traits
	 *
	 * @var PHPParser_Node_Name[]
	 */
	protected $traits;

	/**
	 * Contains adaptations
	 *
	 * @var PHPParser_Node_Stmt_TraitUseAdaptation[]
	 */
	protected $adaptations;

	/**
	 * Constructs a trait use node.
	 *
	 * @param PHPParser_Node_Name[] $traits Traits
	 * @param PHPParser_Node_Stmt_TraitUseAdaptation[] $adaptations Adaptations
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct(array $traits, array $adaptations = array(), $line = -1, $ignorables = array()) {
		$this->setTraits($traits);
		$this->setAdaptations($adaptations);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Stmt_TraitUseAdaptation $adaptation
	 */
	public function appendAdaptation(PHPParser_Node_Stmt_TraitUseAdaptation $adaptation) {
		if (NULL != $this->adaptations) {
			$this->adaptations = array();
		}
		$this->adaptations[] = $adaptation;
		$this->setSelfAsSubNodeParent($adaptation, 'adaptations');
	}

	/**
	 * @param PHPParser_Node_Stmt_TraitUseAdaptation $adaptation
	 */
	public function removeAdaptation(PHPParser_Node_Stmt_TraitUseAdaptation $adaptation) {
		if (NULL !== $this->adaptations) {
			foreach ($this->adaptations as $key => $existingAdaptation) {
				if ($adaptation === $existingAdaptation) {
					unset($this->adaptations[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_TraitUseAdaptation $adaptationNew
	 * @param PHPParser_Node_Stmt_TraitUseAdaptation $adaptationOld
	 */
	public function replaceAdaptation(PHPParser_Node_Stmt_TraitUseAdaptation $adaptationNew, PHPParser_Node_Stmt_TraitUseAdaptation $adaptationOld) {
		if (NULL !== $this->adaptations) {
			foreach ($this->adaptations as $key => $existingAdaptation) {
				if ($adaptationOld === $existingAdaptation) {
					$this->adaptations[$key] = $adaptationNew;
					$existingAdaptation->setParent();
					$this->setSelfAsSubNodeParent($adaptationNew, 'adaptations');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_TraitUseAdaptation[] $adaptations
	 * @return \PHPParser_Node_Stmt_TraitUse
	 */
	public function setAdaptations(array $adaptations) {
		$this->adaptations = $adaptations;
		$this->setSelfAsSubNodeParent($adaptations, 'adaptations');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_TraitUseAdaptation
	 */
	public function getAdaptationAtIndex($index = NULL) {
		if (isset($this->adaptations[$index])) {
			return $this->adaptations[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_TraitUseAdaptation[]
	 */
	public function getAdaptations() {
		return $this->adaptations;
	}

	/**
	 * @param PHPParser_Node_Name $trait
	 */
	public function appendTrait(PHPParser_Node_Name $trait) {
		if (NULL != $this->traits) {
			$this->traits = array();
		}
		$this->traits[] = $trait;
		$this->setSelfAsSubNodeParent($trait, 'traits');
	}

	/**
	 * @param PHPParser_Node_Name $trait
	 */
	public function removeTrait(PHPParser_Node_Name $trait) {
		if (NULL !== $this->traits) {
			foreach ($this->traits as $key => $existingTrait) {
				if ($trait === $existingTrait) {
					unset($this->traits[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Name $traitNew
	 * @param PHPParser_Node_Name $traitOld
	 */
	public function replaceTrait(PHPParser_Node_Name $traitNew, PHPParser_Node_Name $traitOld) {
		if (NULL !== $this->traits) {
			foreach ($this->traits as $key => $existingTrait) {
				if ($traitOld === $existingTrait) {
					$this->traits[$key] = $traitNew;
					$existingTrait->setParent();
					$this->setSelfAsSubNodeParent($traitNew, 'traits');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Name[] $traits
	 * @return \PHPParser_Node_Stmt_TraitUse
	 */
	public function setTraits(array $traits) {
		$this->traits = $traits;
		$this->setSelfAsSubNodeParent($traits, 'traits');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Name
	 */
	public function getTraitAtIndex($index = NULL) {
		if (isset($this->traits[$index])) {
			return $this->traits[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Name[]
	 */
	public function getTraits() {
		return $this->traits;
	}
}