<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen <mail@ndh-websolutions.de>
 *
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
class Tx_Classparser_Domain_Model_File {

	protected $filePathAndName = '';

	protected $nameSpaces = array();

	protected $preIncludes = array();

	protected $classes = array();

	protected $nameSpacedClasses = array();

	protected $postIncludes = array();

	public function addClass($class) {
		$this->classes[] = $class;
	}

	public function getClasses() {
		return $this->classes;
	}

	public function addNameSpacedClass($nameSpace, $class) {
		$this->nameSpacedClasses[$nameSpace] = $class;
	}

	public function getNameSpacedClasses() {
		return $this->nameSpacedClasses;
	}

	public function getFirstClass() {
		if(count($this->nameSpacedClasses) > 0) {
			foreach($this->nameSpacedClasses as $nameSpace => $class) {
				return $class;
			}
		}
		reset($this->classes);
		return current($this->classes);
	}

	public function setSingleClass($classObject) {
		$this->classes = array();
		$this->classes[] = $classObject;
	}

	public function addNameSpace($nameSpace) {
		$this->nameSpaces[] = $nameSpace;
	}

	public function getNameSpaces() {
		return $this->nameSpaces;
	}

	public function addPostInclude($postInclude) {
		$this->postIncludes[] = $postInclude;
	}

	public function getPostIncludes() {
		return $this->postIncludes;
	}

	public function addPreIncludes($preInclude) {
		$this->preIncludes[] = $preInclude;
	}

	public function getPreIncludes() {
		return $this->preIncludes;
	}

	public function setFilePathAndName($filePathAndName) {
		$this->filePathAndName = $filePathAndName;
	}

	public function getFilePathAndName() {
		return $this->filePathAndName;
	}

	public function getStmts() {
		$stmts = array();
		$stmts += $this->nameSpaces;
		foreach($this->preIncludes as $preInclude) {
			$stmts[] = $preInclude;
		}

		foreach($this->classes as $class) {
			$stmts[] = $class->getNode();
		}
		foreach($this->postIncludes as $postInclude) {
			$stmts[] = $postInclude;
		}
		return $stmts;
	}
}

?>