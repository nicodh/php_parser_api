<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Nico de Haen <mail@ndh-websolutions.de>
*  All rights reserved
*
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
* @package classparser
* @author Nico de Haen
*/


/**
* provides methods to import a class object and methods and properties
*
* @package Classparser
* @version $ID:$
*/

class Tx_Classparser_Parser_Visitor_ClassVisitor extends PHPParser_NodeVisitorAbstract {
	protected $properties = array();

	/**
	 * @var Tx_Classparser_Domain_Model_Class
	 */
	protected $classObject = NULL;

	protected $preIncludes = array();

	protected $postIncludes = array();

	protected $nameSpaces = array();

	public function getClassObject() {
		return $this->classObject;
	}

	public function enterNode(PHPParser_Node $node) {

		if($node instanceof PHPParser_Node_Expr_Include) {
			if($this->classObject === NULL) {
				$this->preIncludes[$node->getLine()] = $node;
			} else {
				$this->postIncludes[$node->getLine()] = $node;
			}
		}

		if($node instanceof PHPParser_Node_Stmt_Use) {
			$this->nameSpaces[$node->getLine()] = $node;
		}

		// PHPParser_Node_Stmt_ClassConst ??
		if($node instanceof PHPParser_Node_Stmt_Class) {
			$this->classObject = new Tx_Classparser_Domain_Model_Class($node->__get('name'));
			//t3lib_utility_Debug::debug($node, 'classObject: ' . $node->__get('name'));
		}

		if($node instanceof PHPParser_Node_Stmt_Property) {
			$property = new Tx_Classparser_Domain_Model_Class_Property($node);
			if($this->classObject) {
				$this->classObject->addProperty($property);
			}
			//t3lib_utility_Debug::debug($property, 'property: ' . $property->getName());
			//$prettyPrinter = new PHPParser_PrettyPrinter_TYPO3CGL;
			//t3lib_utility_Debug::debug($prettyPrinter->prettyPrint($property->getStmnts()), 'property: ' . $property->getName());
			//t3lib_utility_Debug::debug($property, 'property: ' . $property->getName());
		}

		if($node instanceof PHPParser_Node_Stmt_ClassMethod) {
			$method = new Tx_Classparser_Domain_Model_Class_Method($node);
			if($this->classObject) {
				$this->classObject->addMethod($method);
			}
			//$prettyPrinter = new PHPParser_PrettyPrinter_TYPO3CGL;
			//t3lib_utility_Debug::debug($prettyPrinter->prettyPrint($node->__get('stmts')), 'method body: ' . $method->getName());
		}

	}

	public function beforeTraverse(array $nodes){}
	public function leaveNode(PHPParser_Node $node){}
	public function afterTraverse(array $nodes){}
}