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
class Tx_Classparser_Domain_Model_Property extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * varType
	 *
	 * @var string
	 */
	protected $varType;

	/**
	 * default
	 *
	 * @var string
	 */
	protected $default;

	/**
	 * value
	 *
	 * @var string
	 */
	protected $value;

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
	 * Returns the default
	 *
	 * @return string $default
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * Sets the default
	 *
	 * @param string $default
	 * @return void
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * Returns the value
	 *
	 * @return string $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Sets the value
	 *
	 * @param string $value
	 * @return void
	 */
	public function setValue($value) {
		$this->value = $value;
	}

}
?>