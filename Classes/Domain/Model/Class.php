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
class Tx_Classparser_Domain_Model_Class extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * fileName
	 *
	 * @var string
	 */
	protected $fileName;

	/**
	 * constants
	 *
	 * @var string
	 */
	protected $constants;

	/**
	 * properties
	 *
	 * @var string
	 */
	protected $properties;

	/**
	 * methods
	 *
	 * @var string
	 */
	protected $methods;

	/**
	 * Returns the fileName
	 *
	 * @return string $fileName
	 */
	public function getFileName() {
		return $this->fileName;
	}

	/**
	 * Sets the fileName
	 *
	 * @param string $fileName
	 * @return void
	 */
	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}

	/**
	 * Returns the constants
	 *
	 * @return string $constants
	 */
	public function getConstants() {
		return $this->constants;
	}

	/**
	 * Sets the constants
	 *
	 * @param string $constants
	 * @return void
	 */
	public function setConstants($constants) {
		$this->constants = $constants;
	}

	/**
	 * Returns the properties
	 *
	 * @return string $properties
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * Sets the properties
	 *
	 * @param string $properties
	 * @return void
	 */
	public function setProperties($properties) {
		$this->properties = $properties;
	}

	/**
	 * Returns the methods
	 *
	 * @return string $methods
	 */
	public function getMethods() {
		return $this->methods;
	}

	/**
	 * Sets the methods
	 *
	 * @param string $methods
	 * @return void
	 */
	public function setMethods($methods) {
		$this->methods = $methods;
	}

}
?>