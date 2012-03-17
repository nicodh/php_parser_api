<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package classparser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Classparser_Domain_Model_MethodParameter extends Tx_Classparser_Domain_Model_AbstractObject {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * varType
	 *
	 * @var string
	 */
	protected $varType;

	/**
	 * typeHint
	 *
	 * @var string
	 */
	protected $typeHint;

	/**
	 * defaultValue
	 *
	 * @var string
	 */
	protected $defaultValue;

	/**
	 * position
	 *
	 * @var integer
	 */
	protected $position;

	/**
	 * optional
	 *
	 * @var boolean
	 */
	protected $optional = FALSE;

	/**
	 * passedByReference
	 *
	 * @var boolean
	 */
	protected $passedByReference = FALSE;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the varType
	 *
	 * @return string $varType
	 */
	public function getVarType() {
		return $this->varType;
	}

	/**
	 * Sets the varType
	 *
	 * @param string $varType
	 * @return void
	 */
	public function setVarType($varType) {
		$this->varType = $varType;
	}

	/**
	 * Returns the typeHint
	 *
	 * @return string $typeHint
	 */
	public function getTypeHint() {
		return $this->typeHint;
	}

	/**
	 * Sets the typeHint
	 *
	 * @param string $typeHint
	 * @return void
	 */
	public function setTypeHint($typeHint) {
		$this->typeHint = $typeHint;
	}

	/**
	 * Returns the defaultValue
	 *
	 * @return string $defaultValue
	 */
	public function getDefaultValue() {
		return $this->defaultValue;
	}

	/**
	 * Sets the defaultValue
	 *
	 * @param string $defaultValue
	 * @return void
	 */
	public function setDefaultValue($defaultValue) {
		$this->defaultValue = $defaultValue;
	}

	/**
	 * Returns the position
	 *
	 * @return integer $position
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * Sets the position
	 *
	 * @param integer $position
	 * @return void
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * Returns the optional
	 *
	 * @return boolean $optional
	 */
	public function getOptional() {
		return $this->optional;
	}

	/**
	 * Sets the optional
	 *
	 * @param boolean $optional
	 * @return void
	 */
	public function setOptional($optional) {
		$this->optional = $optional;
	}

	/**
	 * Returns the boolean state of optional
	 *
	 * @return boolean
	 */
	public function isOptional() {
		return $this->getOptional();
	}

	/**
	 * Returns the passedByReference
	 *
	 * @return boolean $passedByReference
	 */
	public function getPassedByReference() {
		return $this->passedByReference;
	}

	/**
	 * Sets the passedByReference
	 *
	 * @param boolean $passedByReference
	 * @return void
	 */
	public function setPassedByReference($passedByReference) {
		$this->passedByReference = $passedByReference;
	}

	/**
	 * Returns the boolean state of passedByReference
	 *
	 * @return boolean
	 */
	public function isPassedByReference() {
		return $this->getPassedByReference();
	}

}
?>