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
 * @author Nico de Haen
 * @package PhpParserApi
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PhpParser_Domain_Model_File extends Tx_PhpParser_Domain_Model_Container{

	protected $filePathAndName = '';

	/**
	 * @var array of Tx_PhpParser_Domain_Model_Namespace
	 */
	protected $namespaces = array();


	/**
	 * @var array all statements
	 */
	protected $stmts = array();

	/**
	 * @var array with PHPParser_Node_Stmts !!
	 */
	protected $aliasDeclarations = array();

	/**
	 * @var array Tx_PhpParser_Domain_Model_Function
	 */
	protected $functions = array();

	/**
	 * @param Tx_PhpParser_Domain_Model_Class $class
	 */
	public function addClass(Tx_PhpParser_Domain_Model_Class $class) {
		$this->classes[] = $class;
	}

	/**
	 * @param string $className
	 * @return Tx_PhpParser_Domain_Model_Class
	 */
	public function getClassByName($className) {
		foreach($this->getClasses() as $class) {
			if($class->getName() == $className) {
				return $class;
			}
		}
	}

	/**
	 * @return array
	 */
	public function getClasses() {
		if(count($this->namespaces) > 0) {
			return reset($this->namespaces)->getClasses();
		} else {
			return $this->classes;
		}
	}


	/**
	 * @param Tx_PhpParser_Domain_Model_Namespace $namespace
	 */
	public function addNamespace(Tx_PhpParser_Domain_Model_Namespace $namespace) {
		$this->namespaces[] = $namespace;
	}

	/**
	 * @return array Tx_PhpParser_Domain_Model_Namespace
	 */
	public function getNamespaces() {
		return $this->namespaces;
	}

	public function hasNamespaces() {
		return (count($this->namespaces) > 0);
	}


	/**
	 * @param string $filePathAndName
	 */
	public function setFilePathAndName($filePathAndName) {
		$this->filePathAndName = $filePathAndName;
	}

	/**
	 * @return string
	 */
	public function getFilePathAndName() {
		return $this->filePathAndName;
	}

	/**
	 * @return array
	 */
	public function getStmts() {
		$this->stmts = array();
		if($this->hasNamespaces()) {
			foreach($this->namespaces as $namespace) {
				$this->stmts[] = $namespace->getNode();
				foreach($namespace->getAliasDeclarations() as $aliasDeclaration) {
					$this->stmts[] = $aliasDeclaration;
				}
				$this->addSubStatements( $namespace);
			}
		} else {
			$this->addSubStatements($this);
		}
		return $this->stmts;
	}

	/**
	 * @param $parentObject either a file object or a namespace object
	 */
	protected function addSubStatements($parentObject) {

		foreach($parentObject->getPreClassStatements() as $preInclude) {
			$this->stmts[] = $preInclude;
		}

		foreach($parentObject->getClasses() as $class) {
			$this->stmts[] = $class->getNode();
		}

		foreach($parentObject->getFunctions() as $function) {
			$this->stmts[] = $function->getNode();
		}

		foreach($this->getPostClassStatements() as $postInclude) {
			$this->stmts[] = $postInclude;
		}
	}

	/**
	 * @param array $aliasDeclarations PHPParser_Node_Stmt
	 */
	public function addAliasDeclarations($aliasDeclarations) {
		$this->aliasDeclarations = $aliasDeclarations;
	}

	/**
	 * @return array PHPParser_Node_Stmt
	 */
	public function getAliasDeclarations() {
		return $this->aliasDeclarations;
	}


}

?>
